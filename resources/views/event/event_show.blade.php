@extends('layouts.app')

@section('title', 'Mis Eventos')

@section('content')
<div class="container mt-5">
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
    <div class="container mt-5" style="min-height: 50vh;">
        @if ($events->isEmpty())
        <p class="text-muted text-center">No hay eventos organizados en este momento.</p>
        @else
        <div class="row mt-4">
            @foreach ($events as $event)
            <!-- Cada evento ocupa una columna -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <!-- Imagen del Evento -->
                    <img src="{{ asset('storage/'.$event->image_url) }}" alt="Imagen del evento" class="img-fluid">
                    <div class="card-body">
                        <!-- Título del Evento -->
                        <h5 class="card-title">{{ $event->title }}</h5>
                        @if (Auth::check() && Auth::user()->role === 'u')
                        <h6 class="text-muted">{{ $event->organizer?->name }}</h6>
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
                        @endif

                        <!-- Botones de acción -->
                        @if (Auth::check() && Auth::user()->role === 'u')
                            @if ($registered === true)
                            <form action="{{ route('events.deleteFromEvent', $event->id) }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Borrarse</button>
                            </form>
                            @else
                            <form action="{{ route('events.register', $event->id) }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Registrarse</button>
                            </form>
                            @endif
                        @endif

                        @if (Auth::check() && Auth::user()->role === 'o')
                        <div class="d-flex flex-column justify-content-center mt-2 gap-2">
                            <!-- Botón de actualizar -->
                            <a href="{{ route('events.updateform', $event->id) }}" class="btn btn-primary btn-sm">Actualizar</a>
                            <!-- Botón de Borrar -->
                            <form action="{{ route('events.delete', $event) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este evento?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Borrar</button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
