<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Events;
use App\Models\Category;

class EventsController extends Controller
{
    public function index()
    {
        $organizerId = Auth::id(); // Obtener el ID del organizador autenticado
        $events = Events::where('organizer_id', $organizerId)
            ->where('deleted', '!=', 1)
            ->get();

        return view('event.event_show', compact('events'));
    }

    public function update(Request $request, $id)
    {
        $event = Events::findOrFail($id);

        // Validar los datos entrantes
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de imagen opcional
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'max_attendees' => 'required|integer|min:1',
        ]);
    
        // Actualizar el evento con los datos válidos
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('event_images', 'public');
            $data['image'] = $imagePath;
        }

        // Actualizar el evento
        $event->update($request->all());

        return redirect()->route('events.get', $id)->with('success', 'Evento actualizado con éxito.');
    }

    public function updateForm($id){
        $event = Events::findOrFail($id);
        $categories = Category::all();
        return view('event.event_update', compact('event', 'categories'));
    }

    public function destroy(Events $event)
    {
        // Soft delete del evento
        $event->deleted = 1;
        $event->save();

        return redirect()->back()->with('message', 'Evento marcado como eliminado.');
    }

    public function filter($categoryName)
    {
        // Buscar la categoría por su nombre
        $category = Category::where('name', $categoryName)->first();

        // Verificar si se encontró la categoría
        if (!$category) {
            // Manejar el caso en que no se encuentra la categoría (opcional)
            return redirect()->back()->with('error', 'Categoría no encontrada.');
        }

        // Obtener el ID de la categoría
        $categoryId = $category->id;

        // Filtrar eventos según el ID de la categoría
        $events = Events::where('category_id', $categoryId)->
        where('deleted', '!=', 1)
        ->get();

        return view('event.event_show', compact('events'));
    }

    public function createView()
    {
        $categories = Category::all();
        return view('event.event_create', compact('categories'));
    }

    protected function create(array $data)
    {
        $urlImagePath = null;

        // Verificar si se ha subido una imagen de perfil
        if (request()->hasFile('image_url')) {
            $urlImagePath = request()->file('image_url')->store('profile_images', 'public');
        }

        return Events::create([
            'organizer_id' => Auth::id(),
            'title' => $data['title'],
            'description' => $data['description'],
            'category_id' => $data['category_id'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'location' => $data['location'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'max_attendees' => $data['max_attendees'],
            'price' => $data['price'],
            'image_url' => $urlImagePath,
            'deleted' => 0,
        ]);
    }

    public function store(Request $request)
    {
        // Validación de los datos del evento
        $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'max_attendees' => 'nullable|integer',
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Crear el evento utilizando el método create
        $event = $this->create($request->all());

        // Redireccionar o devolver una respuesta
        return redirect()->route('events.get')->with('success', 'Evento creado exitosamente.');
    }
}
