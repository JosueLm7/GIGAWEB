@extends('layouts.app')

@section('title', 'Detalles del Cliente')

@section('content')
    <h1 class="my-4">Detalles del Cliente</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $cliente->nombres }} {{ $cliente->apellido_paterno }} {{ $cliente->apellido_materno }}</h5>
            <p class="card-text">Correo Electrónico: {{ $cliente->correo_electronico }}</p>
            <p class="card-text">Teléfono: {{ $cliente->telefono }}</p>
            <p class="card-text">Dirección: {{ $cliente->direccion }}</p>
            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning">Editar</a>
            <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    </div>
@endsection
