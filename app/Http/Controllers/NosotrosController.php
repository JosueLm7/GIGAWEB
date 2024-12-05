<?php

namespace App\Http\Controllers;

use App\Models\NotificacionUsuario;
use App\Models\NotificacionCliente;
use App\Models\Usuario;
use App\Models\Cliente;
use Illuminate\Http\Request;

class NosotrosController extends Controller // Cambia Controllers a Controller
{
    public function index() {
        return view('nosotros.index'); // Asegúrate de que el nombre sea correcto
    }
}
