@extends('layouts.app')

@section('title', 'Lista de Facturas')

@section('content')
    <h1 class="my-4">Lista de Facturas</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Monto</th>
                <th>Fecha de Vencimiento</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($facturas as $factura)
                <tr>
                    <td>{{ $factura->id }}</td>
                    <td>{{ $factura->cliente->nombre }}</td>
                    <td>{{ $factura->monto }}</td>
                    <td>{{ $factura->fecha_vencimiento }}</td>
                    <td>{{ $factura->estado }}</td>
                    <td>
                        <a href="{{ route('facturas.edit', $factura) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('facturas.destroy', $factura) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('facturas.create') }}" class="btn btn-primary">Crear Nueva Factura</a>
@endsection
