<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'contrasena' => 'required|string',
        ]);

        // Intentar autenticar al usuario
        $usuario = Usuario::where('email', $request->email)->first();

        if ($usuario && password_verify($request->contrasena, $usuario->contrasena)) {
            Auth::login($usuario); // Inicia sesión
            $usuario->estado = true; // Cambiar estado a en línea
            $usuario->save();
            return redirect()->route('home'); // Redirige a la página principal
        }

        // Si la autenticación falla, se agregan errores a la sesión
        return redirect()->back()->withErrors(['email' => 'Credenciales incorrectas'])->withInput();
    }

    public function logout(Request $request)
    {
        $usuario = Auth::user();
        if ($usuario) {
            $usuario->estado = false; // Cambiar estado a fuera de línea
            $usuario->save();
        }
        
        Auth::logout();
        return redirect()->route('login');
    }
}
