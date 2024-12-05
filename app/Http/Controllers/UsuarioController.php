<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public function index($id)
    {
        // Verifica si el ID en la ruta coincide con el usuario autenticado
        if ($id != Auth::id()) {
            abort(403); // Prohibido
        }

        // Obtener todos los usuarios, excepto el que está autenticado
        $usuarios = Usuario::where('id', '!=', Auth::id())->get();
        
        return view('notificaciones.usuarios.index', compact('usuarios'));
    }
}
