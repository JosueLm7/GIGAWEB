@extends('layouts.app')

@section('title', 'Editar Cliente')

@section('content')
    <h1 class="my-4">Editar Cliente</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('clientes.update', $cliente) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombres">Nombres:</label>
            <input type="text" id="nombres" name="nombres" class="form-control" value="{{ old('nombres', $cliente->nombres) }}" required>
        </div>
        <div class="form-group">
            <label for="apellido_paterno">Apellido Paterno:</label>
            <input type="text" id="apellido_paterno" name="apellido_paterno" class="form-control" value="{{ old('apellido_paterno', $cliente->apellido_paterno) }}" required>
        </div>
        <div class="form-group">
            <label for="apellido_materno">Apellido Materno:</label>
            <input type="text" id="apellido_materno" name="apellido_materno" class="form-control" value="{{ old('apellido_materno', $cliente->apellido_materno) }}" required>
        </div>
        <div class="form-group">
            <label for="correo_electronico">Correo Electrónico:</label>
            <input type="email" id="correo_electronico" name="correo_electronico" class="form-control" value="{{ old('correo_electronico', $cliente->correo_electronico) }}" required>
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" class="form-control" value="{{ old('telefono', $cliente->telefono) }}" required>
        </div>
        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" class="form-control" value="{{ old('direccion', $cliente->direccion) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
    </form>
@endsection
