<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    // Los atributos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'creado_en',
        'actualizado_en',
    ];

    // Relaciones
    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'cliente_producto');
    }
}
