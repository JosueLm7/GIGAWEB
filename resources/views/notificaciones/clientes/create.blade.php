@extends('layouts.app')

@section('title', 'Enviar Notificación a Cliente')

@section('content')
    <h1>Enviar Notificación a Cliente</h1>

    <form action="{{ route('notificaciones.clientes.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="cliente_id">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-control" required>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombres }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="mensaje">Mensaje</label>
            <textarea name="mensaje" id="mensaje" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
@endsection
