@extends('layouts.app')

@section('title', 'Crear Evento')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Crear un Nuevo Evento</h1>

    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <!-- Mensajes de Error -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario de Creación de Evento -->
            <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Título del Evento -->
                <div class="form-group mb-3">
                    <label for="title">Título del Evento</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Ingresa el título del evento" value="{{ old('title') }}" required>
                </div>

                <!-- Fecha y Hora de Inicio -->
                <div class="form-group mb-3">
                    <label for="start_time">Fecha y Hora de Inicio</label>
                    <input type="datetime-local" class="form-control" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="end_time">Fecha y Hora de Finalización</label>
                    <input type="datetime-local" class="form-control" id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                </div>

                <!-- Imagen del Evento -->
                <div class="form-group mb-3">
                    <label for="image">Imagen del Evento</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                </div>

                <!-- Descripción del Evento -->
                <div class="form-group mb-3">
                    <label for="description">Descripción del Evento</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe los detalles del evento">{{ old('description') }}</textarea>
                </div>

                <!-- Botón de Crear Evento -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Crear Evento</button>
                    <a href="{{ route('events.store') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
