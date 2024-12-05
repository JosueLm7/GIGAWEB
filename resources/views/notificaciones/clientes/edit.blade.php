@extends('layouts.app')

@section('title', 'Editar Notificación')

@section('content')
    <h1>Editar Notificación</h1>

    <form action="{{ route('notificaciones.clientes.update', $notificacion) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="cliente_id">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-control" required>
                <option value="{{ $notificacion->cliente_id }}">{{ $notificacion->cliente->nombres }}</option>
                @foreach ($clientes as $cliente)
                    @if ($cliente->id != $notificacion->cliente_id)
                        <option value="{{ $cliente->id }}">{{ $cliente->nombres }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="mensaje">Mensaje</label>
            <textarea name="mensaje" id="mensaje" class="form-control" required>{{ $notificacion->mensaje }}</textarea>
        </div>

        <button type="submit" class="btn btn-warning">Actualizar</button>
    </form>
@endsection
