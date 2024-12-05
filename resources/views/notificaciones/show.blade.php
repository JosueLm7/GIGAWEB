@extends('layouts.app')

@section('title', 'Detalles de Notificación')

@section('content')
    <h1 class="my-4">Detalles de Notificación</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Notificación #{{ $notificacion->id }}</h5>
            <p class="card-text">Mensaje: {{ $notificacion->mensaje }}</p>
            <p class="card-text">Leída: {{ $notificacion->leida ? 'Sí' : 'No' }}</p>
            <a href="{{ route('notificaciones.edit', $notificacion) }}" class="btn btn-warning">Editar</a>
            <form action="{{ route('notificaciones.destroy', $notificacion) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    </div>
@endsection
