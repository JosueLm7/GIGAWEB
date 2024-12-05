@extends('layouts.app')

@section('title', 'Crear Factura')

@section('content')
    <h1 class="my-4">Crear Nueva Factura</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('facturas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="cliente_id">Cliente:</label>
            <select id="cliente_id" name="cliente_id" class="form-control" required>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="monto">Monto:</label>
            <input type="number" id="monto" name="monto" class="form-control" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="fecha_vencimiento">Fecha de Vencimiento:</label>
            <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="estado">Estado:</label>
            <select id="estado" name="estado" class="form-control" required>
                <option value="pendiente">Pendiente</option>
                <option value="pagado">Pagado</option>
                <option value="vencido">Vencido</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Factura</button>
    </form>
@endsection
