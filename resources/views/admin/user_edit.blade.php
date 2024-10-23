@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Usuario</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" value="{{ $user->email }}" disabled>
        </div>

        <div class="form-group">
            <label for="role">Rol</label>
            <input type="text" class="form-control" id="role" value="{{ $user->role }}" disabled>
        </div>

        <div class="form-group">
            <label for="actived">Activado</label>
            <input type="text" class="form-control" id="actived" value="{{ $user->actived ? 'Sí' : 'No' }}" disabled>
        </div>

        <div class="form-group">
            <label for="email_confirmed">Email Confirmado</label>
            <input type="text" class="form-control" id="email_confirmed" value="{{ $user->email_confirmed ? 'Sí' : 'No' }}" disabled>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Nombre</button>
        <a href="{{ route('admin.users') }}" class="btn btn-secondary">Volver</a> <!-- Botón de volver -->
    </form>
</div>
@endsection
