@extends('layouts.app')

@section('title', 'Editar Notificación de Usuario')

@section('content')
    <h1 class="my-4">Editar Notificación de Usuario</h1>

    <form action="{{ route('notificaciones.usuarios.update', $notificacion) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="usuario_id">Seleccionar Usuario:</label>
            <select id="usuario_id" name="usuario_id" class="form-control" required>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ $notificacion->usuario_id == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" name="mensaje" class="form-control" required>{{ $notificacion->mensaje }}</textarea>
        </div>

        <div class="form-group">
            <label for="leida">Leída:</label>
            <input type="checkbox" id="leida" name="leida" value="1" {{ $notificacion->leida ? 'checked' : '' }}>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Notificación</button>
    </form>
@endsection
