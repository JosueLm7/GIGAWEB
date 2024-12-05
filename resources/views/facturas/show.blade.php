@extends('layouts.app')

@section('title', 'Detalles de Factura')

@section('content')
    <h1 class="my-4">Detalles de Factura</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Factura #{{ $factura->id }}</h5>
            <p class="card-text">Cliente: {{ $factura->cliente->nombre }}</p>
            <p class="card-text">Total: {{ $factura->total }}</p>
            <p class="card-text">Fecha: {{ $factura->fecha }}</p>
            <a href="{{ route('facturas.edit', $factura) }}" class="btn btn-warning">Editar</a>
            <form action="{{ route('facturas.destroy', $factura) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    </div>
@endsection
