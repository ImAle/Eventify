<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Events;

class EventsController extends Controller
{
    public function get()
    {
        $organizerId = Auth::id(); // Obtener el ID del organizador autenticado
        $events = Events::where('id_organizador', $organizerId)
            ->where('deleted', 0) // Asegurarse de obtener solo eventos no eliminados
            ->get();

        return view('event.get', compact('events'));
    }

    public function update(Request $request, $id)
    {
        $event = Events::findOrFail($id);

        // Validar los datos entrantes
        $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha' => 'required|date',
            'descripcion' => 'nullable|string',
        ]);

        // Actualizar el evento
        $event->update($request->all());

        return redirect()->route('event.update', $id)->with('success', 'Evento actualizado con éxito.');
    }

    public function destroy(Events $event)
    {   
        // Soft delete del evento
        $event->deleted = 1;
        $event->save();

        return redirect()->back()->with('message', 'Evento marcado como eliminado.');
    }
}
