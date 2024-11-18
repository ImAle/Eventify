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

    public function registerToEvent($id)
    {
        $event = Events::findOrFail($id); // Buscar el evento por su ID
        $user = Auth::user(); // Usuario autenticado

        // Verificar si el usuario ya está registrado en el evento
        if ($event->users()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Ya estas registrado en el evento.');
        }

        // Registrar al usuario en el evento
        $event->users()->attach($user->id, ['registered_at' => now()]);

        // Responder con éxito
        return back()->with('success', 'Te has registrado en el evento.');
    }

    public function deleteFromEvent($id)
    {
        $event = Events::findOrFail($id); // Buscar el evento por su ID
        $user = Auth::user(); // Usuario autenticado

        // Verificar si el usuario está registrado en el evento
        if (!$event->users()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'No estás registrado en este evento.');
        }

        // Desregistrar al usuario del evento
        $event->users()->detach($user->id);

        // Redirigir a la misma página con un mensaje de éxito
        return back()->with('success', 'Te has borrado del evento exitosamente.');
    }

    public function indexUser($registered)
    {
        $user = Auth::user();
        $events = Events::with('organizer')
            ->where('deleted', '!=', 1)
            ->whereDate('start_time', '>', now());

        if ($registered) {
            // Mostrar solo los eventos donde el usuario está registrado
            $events->whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        } else {
            // Mostrar solo los eventos donde el usuario NO está registrado
            $events->whereDoesntHave('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }

        $events = $events->get();

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
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'max_attendees' => 'required|integer|min:1',
        ]);

        $event->organizer_id = Auth::id();
        $event->title = $request->title;
        $event->description = $request->description;
        $event->category_id = $request->category_id;
        $event->start_time = $request->start_time;
        $event->end_time = $request->end_time;
        $event->location = $request->location;
        $event->latitude = $request->latitude;
        $event->longitude = $request->longitude;
        $event->max_attendees = $request->max_attendees;
        $event->price = $request->price;
        $event->deleted = 0;

        // Actualizar el evento con los datos válidos
        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('storage/event_images', 'public');
            $event->image_url = $imagePath;
        }

        // Actualizar el evento
        $event->save();

        return redirect()->route('events.get', $id)->with('success', 'Evento actualizado con éxito.');
    }

    public function updateForm($id)
    {
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
        $events = Events::where('category_id', $categoryId)->where('deleted', '!=', 1)->where('organizer_id', Auth::user()->id)
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
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'max_attendees' => 'required|integer|min:1',
        ]);

        $event = new Events();
        $event->organizer_id = Auth::id();
        $event->title = $request->title;
        $event->description = $request->description;
        $event->category_id = $request->category_id;
        $event->start_time = $request->start_time;
        $event->end_time = $request->end_time;
        $event->location = $request->location;
        $event->latitude = $request->latitude;
        $event->longitude = $request->longitude;
        $event->max_attendees = $request->max_attendees;
        $event->price = $request->price;
        $event->deleted = 0;

        if ($request->hasFile('image_url')) {
            // Almacena la imagen en la carpeta "public/event_images" y guarda la ruta
            $imagePath = $request->file('image_url')->store('storage/event_images', 'public');
            $event->image_url = $imagePath;
        } else {
            // Da imagen por defecto
            $imagePath = 'event_images/image_not_found.jpg';
            $event->image_url = $imagePath;
        }

        // Guardar el evento en la base de datos
        $event->save();

        // Redireccionar con mensaje de éxito
        return redirect()->route('events.get')->with('success', 'Evento creado exitosamente.');
    }
}
