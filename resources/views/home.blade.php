@extends('layouts.app')

@section('title', 'Home')

@section('content')
    
    <!-- Carrusel de Imágenes centrado debajo del contenedor -->
    <div id="imageCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#imageCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#imageCarousel" data-slide-to="1"></li>
            <li data-target="#imageCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="{{ asset('images/imagen1.jpeg') }}" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('images/imagen2.jpeg') }}" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('images/imagen3.jpeg') }}" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <h1 class="my-4">Bienvenido a Corporación Giga</h1>
    <p class="text-justify">En Corporación Giga, somos líderes en el suministro de <span class="text-blue font-weight-bold">internet de fibra óptica</span> de alta velocidad. Nuestro equipo de <span class="text-blue font-weight-bold">profesionales altamente capacitados</span> garantiza una conexión estable y rápida, ideal para hogares y empresas que requieren lo mejor en tecnología de red. Nos enorgullece ofrecer un servicio excepcional y personalizado para cada cliente, asegurando que su experiencia con nosotros sea inigualable.</p>
    <p class="text-justify"><span class="text-blue font-weight-bold">¡Aproveche nuestra oferta especial: Instalación Gratis!</span> No deje pasar esta oportunidad de mejorar su conexión sin ningún costo adicional. Contáctenos hoy mismo y descubra la diferencia que puede hacer un servicio de calidad.</p>


    
@endsection
