<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificacionUsuario extends Model
{
    protected $table = 'notificaciones_usuarios';
    protected $fillable = [
        'usuario_id',
        'mensaje',
        'leida',
        'created_at',
        'updated_at',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
