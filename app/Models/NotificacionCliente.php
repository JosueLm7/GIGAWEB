<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificacionCliente extends Model
{

    protected $table = 'notificaciones_clientes'; // Asegúrate de que este nombre sea correcto
    protected $fillable = [
        'cliente_id',
        'mensaje',
        'leida',
        'created_at',
        'updated_at',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
