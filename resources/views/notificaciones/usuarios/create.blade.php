@extends('layouts.app')

@section('title', 'Crear Notificación de Usuario')

@section('content')
    <h1 class="my-4">Crear Nueva Notificación de Usuario</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('notificaciones.usuarios.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="usuario_id">Seleccionar Usuario:</label>
            <select id="usuario_id" name="usuario_id" class="form-control" required>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}">{{ $usuario->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" name="mensaje" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="leida">Leída:</label>
            <input type="checkbox" id="leida" name="leida" value="1">
        </div>

        <button type="submit" class="btn btn-primary">Crear Notificación</button>
    </form>
@endsection
