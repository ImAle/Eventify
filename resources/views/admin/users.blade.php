@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <h1>Usuarios desactivados</h1>

                    @if (session('status'))
                        <div>{{ session('status') }}</div>
                    @endif

                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->actived)
                                            <!-- Botón de desactivar -->
                                            <form action="{{ route('users.deactivate', $user->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-warning">Desactivar</button>
                                            </form>
                                        @else
                                            <!-- Botón de activar -->
                                            <form action="{{ route('users.activate', $user->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success">Activar</button>
                                            </form>
                                        @endif

                                        <!-- Botón de editar -->
                                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-info">Editar</a>

                                        <!-- Botón de borrar (siempre disponible) -->
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirmDelete()" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Borrar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm('¿Estás seguro de que quieres borrar este usuario?');
    }
</script>

@endsection
