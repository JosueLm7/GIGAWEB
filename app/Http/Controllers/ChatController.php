<?php

namespace App\Http\Controllers;

use App\Models\Mensaje; // Asegúrate de importar el modelo
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function obtenerMensajes($receptorId)
    {
        $usuarioAutenticadoId = Auth::id();

        // Obtener mensajes entre el usuario autenticado y el receptor
        $mensajes = Mensaje::where(function ($query) use ($usuarioAutenticadoId, $receptorId) {
            $query->where('remitente_id', $usuarioAutenticadoId)
                ->where('receptor_id', $receptorId);
        })->orWhere(function ($query) use ($usuarioAutenticadoId, $receptorId) {
            $query->where('remitente_id', $receptorId)
                ->where('receptor_id', $usuarioAutenticadoId);
        })->with(['remitente', 'receptor'])->get(); // Asegúrate de cargar las relaciones

        return response()->json(['mensajes' => $mensajes]);
    }
    

    public function enviarMensaje(Request $request)
    {
        $request->validate([
            'mensaje' => 'required|string',
            'receptor_id' => 'required|exists:usuarios,id', // Cambia 'usuarios' si el nombre de tu tabla es diferente
        ]);

        $mensaje = new Mensaje();
        $mensaje->remitente_id = Auth::id();
        $mensaje->receptor_id = $request->receptor_id;
        $mensaje->mensaje = $request->mensaje;
        $mensaje->save();

        return response()->json(['success' => true]);
    }

    public function obtenerNuevosMensajes(Request $request)
    {
        $usuarioId = $request->input('usuario_id');
        $ultimoId = $request->input('ultimo_id');

        

        $nuevosMensajes = Mensaje::where('receptor_id', auth()->id())
            ->where('remitente_id', $usuarioId)
            ->where('id', '>', $ultimoId)
            ->with('remitente') // Asegúrate de incluir la relación con el remitente
            ->get();

        

        return response()->json($nuevosMensajes);
    }

    public function nuevosMensajes(Request $request)
    {
        $ultimosMensajes = Mensaje::where('remitente_id', '!=', auth()->id())
            ->where('receptor_id', $request->usuario_id)
            ->where('id', '>', $request->ultimo_id)
            ->get();

        return response()->json($ultimosMensajes);
    }


}
