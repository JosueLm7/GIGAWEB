<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

class ClientUpdateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction(); // Inicia la transacción
    }

    protected function tearDown(): void
    {
        DB::rollBack(); // Revierte la transacción
        parent::tearDown();
    }

    public function test_actualizar_cliente_correctamente()
    {
        // Crear un cliente para la prueba
        $cliente = Cliente::create([
            'nombre' => 'Juan Perez',
            'correo_electronico' => 'juan@example.com',
            'telefono' => '123456789',
            'direccion' => 'Calle Falsa 123',
        ]);

        // Actualizar el cliente
        $cliente->update([
            'nombre' => 'Juanito Perez',
            'telefono' => '987654321',
        ]);

        // Verificar que los cambios se hayan realizado correctamente
        $this->assertDatabaseHas('clientes', [
            'id' => $cliente->id,
            'nombre' => 'Juanito Perez',
            'telefono' => '987654321',
        ]);
    }

    public function test_actualizar_cliente_no_existente()
    {
        // Intentar actualizar un cliente que no existe
        $cliente = new Cliente();
        $cliente->id = 999; // ID que no existe

        $resultado = $cliente->update([
            'nombre' => 'Inexistente',
            'telefono' => '000000000',
        ]);

        // Verifica que no se haya realizado la actualización
        $this->assertFalse($resultado);
    }
}
