@extends('layouts.app')

@section('title', 'Editar Factura')

@section('content')
    <h1 class="my-4">Editar Factura</h1>
    <form action="{{ route('facturas.update', $factura) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="cliente_id">Cliente:</label>
            <select id="cliente_id" name="cliente_id" class="form-control" required>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ $factura->cliente_id == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="total">Total:</label>
            <input type="number" id="total" name="total" class="form-control" step="0.01" value="{{ $factura->total }}" required>
        </div>
        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" class="form-control" value="{{ $factura->fecha }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Factura</button>
    </form>
@endsection
