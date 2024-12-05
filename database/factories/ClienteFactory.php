<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    // Especifica el modelo asociado a este factory
    protected $model = Cliente::class;

    // Define los atributos por defecto
    public function definition()
    {
        return [
            'usuario_id' => $this->faker->randomNumber(), // ID de usuario aleatorio
            'nombre' => $this->faker->name(), // Nombre aleatorio
            'correo_electronico' => $this->faker->unique()->safeEmail(), // Correo electrónico único
            'telefono' => $this->faker->phoneNumber(), // Número de teléfono aleatorio
            'direccion' => $this->faker->address(), // Dirección aleatoria
            'creado_en' => now(), // Fecha de creación
            'actualizado_en' => now(), // Fecha de actualización
        ];
    }
}
