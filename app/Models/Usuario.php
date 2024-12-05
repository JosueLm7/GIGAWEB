<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class Usuario extends Authenticatable
{
    use Notifiable;

    // Los atributos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'email',
        'contrasena',
        'estado', // Asegúrate de que este campo esté presente
    ];

    // Oculta el campo de contraseña en las respuestas JSON
    protected $hidden = [
        'contrasena',
    ];

    // Método para obtener la contraseña autenticada
    public function getAuthPassword()
    {
        return $this->contrasena; // Retorna el campo 'contrasena'
    }

    public static function crear(array $data)
    {
        // Validar el email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw ValidationException::withMessages([
                'email' => ['El email no es válido.'],
            ]);
        }

        return self::create($data);
    }

    public function mensajesRecibidos()
    {
        return $this->hasMany(Mensaje::class, 'receptor_id');
    }

    public function mensajesEnviados()
    {
        return $this->hasMany(Mensaje::class, 'remitente_id');
    }

    // Obtener el último mensaje en general
    public function ultimoMensaje()
    {
        return Mensaje::where(function ($query) {
            $query->where('remitente_id', $this->id)
                  ->orWhere('receptor_id', $this->id);
        })->latest()->first()->mensaje ?? null; // Cambia 'mensaje' si el campo se llama diferente
    }

    // Obtener la hora del último mensaje en general
    public function ultimoMensajeHora()
    {
        $ultimoMensaje = $this->mensajesRecibidos()->latest()->first();

        if ($ultimoMensaje) {
            return Carbon::parse($ultimoMensaje->created_at)->format('H:i'); // Cambia el formato según necesites
        }

        return null;
    }

    // Obtener el último mensaje con un usuario específico
    public function ultimoMensajeConUsuario($usuarioId)
    {
        $mensaje = Mensaje::where(function ($query) use ($usuarioId) {
            $query->where('remitente_id', $this->id)
                  ->where('receptor_id', $usuarioId);
        })->orWhere(function ($query) use ($usuarioId) {
            $query->where('remitente_id', $usuarioId)
                  ->where('receptor_id', $this->id);
        })->latest()->first();

        return $mensaje ? $mensaje->mensaje : null; // Cambia 'mensaje' si el campo se llama diferente
    }

    // Obtener la hora del último mensaje con un usuario específico
    public function ultimoMensajeHoraConUsuario($usuarioId)
    {
        $ultimoMensaje = Mensaje::where(function ($query) use ($usuarioId) {
            $query->where('remitente_id', $this->id)
                  ->where('receptor_id', $usuarioId);
        })->orWhere(function ($query) use ($usuarioId) {
            $query->where('remitente_id', $usuarioId)
                  ->where('receptor_id', $this->id);
        })->latest()->first();

        if ($ultimoMensaje) {
            return Carbon::parse($ultimoMensaje->created_at)->format('H:i'); // Cambia el formato según necesites
        }

        return null;
    }
}
