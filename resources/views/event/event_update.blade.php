@extends('layouts.app')

@section('title', 'Actualizar Evento')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Actualizar Evento</h1>

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

            <!-- Formulario de Actualización de Evento -->
            <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Categoría del Evento -->
                <div>
                    <label for="category_id">Categoría del Evento</label>
                    <select class="form-control" id="category_id" name="category_id" required>
                        <option value="" disabled {{ old('category_id', $event->category_id) ? '' : 'selected' }}>Selecciona una categoría</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <br>
                
                <!-- Título del Evento -->
                <div class="form-group mb-3">
                    <label for="title">Título del Evento</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Ingresa el título del evento" value="{{ old('title', $event->title) }}" required>
                </div>

                <!-- Fecha y Hora de Inicio -->
                <div class="form-group mb-3">
                    <label for="start_time">Fecha y Hora de Inicio</label>
                    <input type="datetime-local" class="form-control" id="start_time" name="start_time" value="{{ old('start_time', \Carbon\Carbon::parse($event->start_time)->format('Y-m-d\TH:i')) }}" required>
                </div>
                
                <!-- Fecha y Hora de Finalización -->
                <div class="form-group mb-3">
                    <label for="end_time">Fecha y Hora de Finalización</label>
                    <input type="datetime-local" class="form-control" id="end_time" name="end_time" value="{{ old('end_time', \Carbon\Carbon::parse($event->end_time)->format('Y-m-d\TH:i')) }}" required>
                </div>

                <!-- Imagen del Evento -->
                <div class="form-group mb-3">
                    <label for="image">Imagen del Evento</label><br>
                    <input type="file" class="form-control-file" id="image" name="image_url"><br>
                    <small class="form-text text-muted">Deja este campo vacío si no deseas cambiar la imagen.</small>
                </div>

                <!-- Descripción del Evento -->
                <div class="form-group mb-3">
                    <label for="description">Descripción del Evento</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe los detalles del evento">{{ old('description', $event->description) }}</textarea>
                </div>

                <!-- Precio del Evento -->
                <div class="form-group mb-3">
                    <label for="price">Precio del Evento</label>
                    <input type="number" class="form-control" id="price" name="price" placeholder="Ingresa el precio del evento" value="{{ old('price', $event->price) }}" min="0" step="0.01" required>
                </div>

                <!-- Ubicación -->
                <div class="form-group mb-3">
                    <label for="location">Ubicación</label>
                    <input type="text" class="form-control" id="location" name="location" required value="{{ old('location', $event->location) }}">
                </div>

                <!-- Latitud -->
                <div class="form-group mb-3">
                    <label for="latitude">Latitud</label>
                    <input type="text" class="form-control" id="latitude" name="latitude" required value="{{ old('latitude', $event->latitude) }}">
                </div>

                <!-- Longitud -->
                <div class="form-group mb-3">
                    <label for="longitude">Longitud</label>
                    <input type="text" class="form-control" id="longitude" name="longitude" required value="{{ old('longitude', $event->longitude) }}">
                </div>

                <!-- Máximo de Asistentes -->
                <div class="form-group mb-3">
                    <label for="max_attendees">Máximo de Asistentes</label>
                    <input type="number" class="form-control" id="max_attendees" name="max_attendees" required value="{{ old('max_attendees', $event->max_attendees) }}">
                </div>

                <!-- Botones -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Actualizar Evento</button>
                    <a href="{{ route('events.get') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
