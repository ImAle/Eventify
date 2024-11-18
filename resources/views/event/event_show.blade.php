@extends('layouts.app')

@section('title', 'Mis Eventos')

@section('content')
<div class="container mt-5">
    <!--<h1 class="text-center">Eventos creados por {{ Auth::user()->name }}</h1>-->
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Botón de Crear Nuevo Evento -->
    @if (Auth::check() && Auth::user()->role === 'o')
    <div class="text-center mt-4">
        <a href="{{ route('events.store') }}" class="btn btn-success">Crear Nuevo Evento</a>
    </div>
    @endif

    <!-- Contenedor centrado solo para el mensaje y los eventos -->
    <div class="container mt-5 d-flex justify-content-center align-items-center" style="min-height: 50vh;">
        @if ($events->isEmpty())
        <p class="text-muted text-center">No hay eventos organizados en este momento.</p>
        @else
        <div class="row mt-4">
            @foreach ($events as $event)
            <div class="d-flex col-md-4 mb-4 gap-2">
                <div class="card shadow-sm">
                    <!-- Imagen del Evento -->
                    <img src="{{ asset('storage/'.$event->image_url) }}" alt="Imagen del evento" class="img-fluid">
                    <div class="card-body">
                        <!-- Título del Evento -->
                        <h5 class="card-title">{{ $event->title }}</h5>
                        @if (Auth::check() && Auth::user()->role === 'u')
                        <h5 class="card-organizer">{{ $event->organizer?->name }}</h5>
                        @endif
                        @if (Auth::check() && Auth::user()->role === 'u' && $registered === true)
                            @php
                                $userInEvent = $event->users->firstWhere('id', Auth::id());
                            @endphp
                        @if ($userInEvent)
                            <p class="card-text text-muted mb-1">
                                <strong>Fecha de Registro:</strong> {{ \Carbon\Carbon::parse($userInEvent->pivot->registered_at)->format('d/m/Y') }}
                            </p>
                        @endif
                    </div>
                </div>
                <!-- Botones de Editar y Borrar fuera de la tarjeta -->
                @if (Auth::check() && Auth::user()->role === 'o')
                <div class="d-flex flex-column justify-content-center mt-2 gap-2">
                    <!-- Botón de actualizar -->
                    <a href="{{ route('events.updateform', $event->id) }}" class="btn btn-primary btn-sm me-2">Actualizar</a>
                    <!-- Botón de Borrar -->
                    <form action="{{ route('events.delete', $event) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este evento?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Borrar</button>
                    </form>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>

</div>
@endsection