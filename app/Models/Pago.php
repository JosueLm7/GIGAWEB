<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    // Los atributos que se pueden asignar masivamente
    protected $fillable = [
        'factura_id',
        'monto',
        'fecha_pago',
        'creado_en',
        'actualizado_en',
    ];

    // Relaciones
    public function factura()
    {
        return $this->belongsTo(Factura::class);
    }
}
