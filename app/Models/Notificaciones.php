<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificaciones extends Model
{
    // Los atributos que se pueden asignar masivamente
    protected $fillable = [
        'mensaje',
        'leida',
        'created_at',
        'updated_at',
    ];

    // Relaciones
    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'notificacion_usuario');
    }

    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'notificacion_cliente');
    }
}
