@extends('layouts.app')

@section('title', 'Mis Eventos')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Eventos Organizados por {{ Auth::user()->name }}</h1>
    
    @if ($events->isEmpty())
        <p class="text-muted text-center">No tienes eventos organizados en este momento.</p>
    @else
        <div class="row mt-4">
            @foreach ($events as $event)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <!-- Imagen del Evento -->
                        <img src="{{ $event->image ?? asset('images/default-event.jpg') }}" class="card-img-top" alt="{{ $event->title }}">
                        
                        <div class="card-body">
                            <!-- Título del Evento -->
                            <h5 class="card-title">{{ $event->title }}</h5>
                            
                            <p class="card-text text-muted mb-1">
                            <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($event->start_time)->format('d/m/Y') }}
                            </p>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
    @endif
    
    <!-- Botón de Crear Nuevo Evento -->
    <div class="text-center mt-4">
        <a href="{{ route('events.store') }}" class="btn btn-success">Crear Nuevo Evento</a>
    </div>
</div>
@endsection

