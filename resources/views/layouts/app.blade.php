<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name') }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    @vite(['resources/js/app.js', 'resources/css/app.css']) <!-- Esto es correcto, carga tus scripts y estilos -->
    @yield('styles')

    <style>
        /* Estilos personalizados */
        .header-container {
            background-color: #fbff13;
            border: 2px solid #ffffff;
            padding: 10px;
            display: flex;
            justify-content: space-between; /* Espaciado entre logo y nav */
            align-items: center;
            height: 160px;
        }

        .navbar-custom {
            background-color: #fbff13;
            color: #050505;
            padding: 10px;
            margin-left: 200px;
            width: 100%; /* Asegúrate de que la barra ocupe el ancho completo */
        }

        .navbar-custom .navbar-nav {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: flex-start;
            gap: 20px;
            height: 100%;
        }

        .nav-item {
            margin-right: 20px;
        }

        .nav-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0166fd;
            border-radius: 20px;
            text-align: center;
            color: #ffffff;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .nav-link:hover {
            background-color: #ffffff;
            color: #0a06ce;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-left: auto; /* Mueve al extremo derecho */
            margin-right: 20px;
        }

        .active {
            color: #fbff13;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header-container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" width="300" height="160">
        </a>

        @if (!request()->is('login') && !request()->is('register'))
            <nav class="navbar navbar-expand-lg navbar-custom">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('nosotros.index') ? 'active' : '' }}" href="{{ route('nosotros.index') }}">Nosotros</a>
                        <a class="nav-link {{ request()->routeIs('contactanos.index') ? 'active' : '' }}" href="{{ route('contactanos.index') }}">Contactanos</a>
                    </li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('clientes.index') ? 'active' : '' }}" href="{{ route('clientes.index') }}">Clientes</a>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('facturas.index') ? 'active' : '' }}" href="{{ route('facturas.index') }}">Facturas</a>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('notificaciones*') ? 'active' : '' }}" href="#" id="notificacionesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Notificaciones</a>
                        <div class="dropdown-menu" aria-labelledby="notificacionesDropdown">
                            <a class="dropdown-item" href="{{ route('notificaciones.usuarios.index', ['id' => Auth::id()]) }}">Notificaciones de Usuarios</a>
                            <a class="dropdown-item" href="{{ route('notificaciones.clientes.index') }}">Notificaciones de Clientes</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        @auth
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        @else
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        @endauth
                    </li>
                </ul>
                @auth
                    <div class="user-info">
                        <i class="fas fa-user" style="font-size: 24px;"></i>
                        <span>{{ Auth::user()->nombre }}</span>
                    </div>
                @endauth
            </nav>
        @endif
    </div>

    <div class="container" style="position: relative;">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    @yield('scripts') <!-- Esto permite cargar scripts específicos de cada vista -->
</body>
</html>
