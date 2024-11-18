@extends('layouts.app')

@section('title', 'Mis Eventos')

@section('content')
<div class="container mt-5">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Contenedor centrado solo para el mensaje y los eventos -->
    <div class="container mt-5 d-flex justify-content-center align-items-center" style="min-height: 50vh;">
        @if ($events->isEmpty())
            <p class="text-muted text-center">No hay eventos disponibles en este momento.</p>
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

                                <!-- Nombre del organizador -->
                                <p class="card-text text-muted mb-1">
                                    <strong>Organizador:</strong> {{$event->organizador->name}}
                                </p>

                                <!-- Fecha de registro -->
                                <p class="card-text text-muted mb-1">
                                    <strong>Registrado el:</strong> 
                                    {{ \Carbon\Carbon::parse($event->pivot->registered_at)->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
