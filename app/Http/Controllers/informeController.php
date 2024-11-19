<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class informeController extends Controller
{

    public function generateInforme()
    {
        // Obtener el usuario actual y sus eventos
        $user = Auth::user();
        $events = $user->registeredEvents;

        // Crear la vista para el PDF
        $pdf = Pdf::loadView('informes.events', compact('user', 'events'));

        // Guardar el PDF temporalmente
        $pdfPath = storage_path('app/public/events-' . $user->id . '.pdf');
        $pdf->save($pdfPath);

        // Enviar el correo con el PDF
        Mail::send('emails.informeEvent', ['user' => $user], function ($message) use ($user, $pdfPath) {
            $message->to($user->email)
                ->subject('Eventos Registrados')
                ->attach($pdfPath);
        });

        // Opción: Descargar el PDF directamente
        return $pdf->stream('eventos-' . $user->id . '.pdf');
    }
}
