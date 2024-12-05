<?php

namespace App\Http\Controllers;

use App\Models\NotificacionUsuario;
use App\Models\NotificacionCliente;
use App\Models\Usuario;
use App\Models\Cliente;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::where('id', '!=', auth()->id())->get();

        return view('notificaciones.usuarios.index', compact('usuarios'));
    }


    public function indexUsuarios()
    {
        $notificacionesUsuarios = NotificacionUsuario::all();
        return view('notificaciones.usuarios.index', compact('notificacionesUsuarios'));
    }

    public function indexClientes()
    {
        $notificacionesClientes = NotificacionCliente::all();
        return view('notificaciones.clientes.index', compact('notificacionesClientes'));
    }

    public function createUsuario()
    {
        $usuarios = Usuario::all();
        return view('notificaciones.usuarios.create', compact('usuarios'));
    }

    public function createCliente()
    {
        $clientes = Cliente::all();
        return view('notificaciones.clientes.create', compact('clientes'));
    }

    public function storeUsuario(Request $request)
    {
        $validatedData = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'mensaje' => 'required|string',
            'leida' => 'boolean',
        ]);

        NotificacionUsuario::create($validatedData);

        return redirect()->route('notificaciones.usuarios.index')->with('success', 'Notificación de Usuario creada exitosamente.');
    }

    public function storeCliente(Request $request)
    {
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'mensaje' => 'required|string',
            'leida' => 'boolean',
        ]);

        $validatedData['leida'] = $validatedData['leida'] ?? 0;

        NotificacionCliente::create($validatedData);

        return redirect()->route('notificaciones.clientes.index')->with('success', 'Notificación de Cliente creada exitosamente.');
    }

    public function editUsuario(NotificacionUsuario $notificacion)
    {
        $usuarios = Usuario::all();
        return view('notificaciones.usuarios.edit', compact('notificacion', 'usuarios'));
    }

    public function editCliente(NotificacionCliente $notificacion)
    {
        $clientes = Cliente::all();
        return view('notificaciones.clientes.edit', compact('notificacion', 'clientes'));
    }

    public function updateUsuario(Request $request, NotificacionUsuario $notificacion)
    {
        $validatedData = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'mensaje' => 'required|string',
            'leida' => 'boolean',
        ]);

        $notificacion->update($validatedData);

        return redirect()->route('notificaciones.usuarios.index')->with('success', 'Notificación de Usuario actualizada exitosamente.');
    }

    public function updateCliente(Request $request, NotificacionCliente $notificacion)
    {
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'mensaje' => 'required|string',
            'leida' => 'boolean',
        ]);

        $notificacion->update($validatedData);

        return redirect()->route('notificaciones.clientes.index')->with('success', 'Notificación de Cliente actualizada exitosamente.');
    }

    public function destroyUsuario(NotificacionUsuario $notificacion)
    {
        $notificacion->delete();
        return redirect()->route('notificaciones.usuarios.index')->with('success', 'Notificación de Usuario eliminada exitosamente.');
    }

    public function destroyCliente(NotificacionCliente $notificacion)
    {
        $notificacion->delete();
        return redirect()->route('notificaciones.clientes.index')->with('success', 'Notificación de Cliente eliminada exitosamente.');
    }
}
