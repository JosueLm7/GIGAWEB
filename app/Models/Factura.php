<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    // Los atributos que se pueden asignar masivamente
    protected $fillable = [
        'cliente_id',
        'monto',
        'fecha_vencimiento',
        'estado',
        'creado_en',
        'actualizado_en',
    ];

    // Relaciones
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
