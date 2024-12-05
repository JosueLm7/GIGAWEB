@extends('layouts.app')

@section('title', 'Notificaciones de Clientes')

@section('content')
    <h1>Notificaciones de Clientes</h1>

    <a href="{{ route('notificaciones.clientes.create') }}" class="btn btn-primary">Enviar Nueva Notificación</a>

    <table class="table">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Mensaje</th>
                <th>Leída</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notificacionesClientes as $notificacion)
                <tr>
                    <td>{{ $notificacion->cliente->nombres }}</td>
                    <td>{{ $notificacion->mensaje }}</td>
                    <td>{{ $notificacion->leida ? 'Sí' : 'No' }}</td>
                    <td>
                        <a href="{{ route('notificaciones.clientes.edit', $notificacion) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('notificaciones.clientes.destroy', $notificacion) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
