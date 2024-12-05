<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Cliente;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    public function index()
    {
        $facturas = Factura::all();
        return view('facturas.index', compact('facturas'));
    }

    public function create()
    {
        $clientes = Cliente::all(); // Obtener todos los clientes
        return view('facturas.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'monto' => 'required|numeric|min:0',
            'fecha_vencimiento' => 'required|date',
            'estado' => 'required|in:pendiente,pagado,vencido',
        ]);

        // Crear una nueva factura
        Factura::create($request->all());

        // Redirigir a la lista de facturas con un mensaje de éxito
        return redirect()->route('facturas.index')->with('success', 'Factura creada con éxito.');
    }

    public function show(Factura $factura)
    {
        return view('facturas.show', compact('factura'));
    }

    public function edit(Factura $factura)
    {
        $clientes = Cliente::all();
        return view('facturas.edit', compact('factura', 'clientes'));
    }

    public function update(Request $request, Factura $factura)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'monto' => 'required|numeric',
            'fecha_vencimiento' => 'required|date',
            'estado' => 'required|in:pendiente,pagado,vencido',
        ]);

        $factura->update($request->all());

        return redirect()->route('facturas.index')->with('success', 'Factura actualizada con éxito.');
    }

    public function destroy(Factura $factura)
    {
        $factura->delete();
        return redirect()->route('facturas.index')->with('success', 'Factura eliminada con éxito.');
    }

    public function storePago(Request $request, Factura $factura)
    {
        $request->validate([
            'monto' => 'required|numeric',
            'fecha_pago' => 'required|date',
        ]);

        $factura->pagos()->create($request->all());

        return redirect()->route('facturas.show', $factura);
    }
}
