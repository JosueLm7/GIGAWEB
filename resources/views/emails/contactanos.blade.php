@extends('layouts.app')

@section('title', 'Contáctanos')

@section('content')
   <div class="container">
       <h2 class="my-4">Correo Electrónico</h2>
       <p>Este es el primer correo que mandamos por Laravel.</p>
       <p><strong>Nombre:</strong> {{ $data['name'] }}</p>
       <p><strong>Correo:</strong> {{ $data['email'] }}</p>
       <p><strong>Mensaje:</strong> {{ $data['message'] }}</p>
   </div>
@endsection
