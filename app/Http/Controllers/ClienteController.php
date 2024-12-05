<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:255|regex:/^[\p{L} ]+$/u',
            'apellido_paterno' => 'required|string|max:255|regex:/^[\p{L} ]+$/u',
            'apellido_materno' => 'required|string|max:255|regex:/^[\p{L} ]+$/u',
            'correo_electronico' => 'required|email|max:255|unique:clientes',
            'telefono' => 'required|string|max:255|unique:clientes',
            'direccion' => 'required|string|max:255',
        ]);

        Cliente::create($request->all());
        return redirect()->route('clientes.index')->with('success', 'Cliente creado con éxito.');
    }

    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombres' => 'required|string|max:255|regex:/^[\p{L} ]+$/u',
            'apellido_paterno' => 'required|string|max:255|regex:/^[\p{L} ]+$/u',
            'apellido_materno' => 'required|string|max:255|regex:/^[\p{L} ]+$/u',
            'correo_electronico' => 'required|email|max:255|unique:clientes,correo_electronico,' . $cliente->id,
            'telefono' => 'required|string|max:255|unique:clientes,telefono,' . $cliente->id,
            'direccion' => 'required|string|max:255',
        ]);

        $cliente->update($request->all());
        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado con éxito.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado con éxito.');
    }
}
