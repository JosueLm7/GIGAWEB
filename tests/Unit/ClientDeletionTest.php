<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

class ClientDeletionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Iniciar la transacción
        DB::beginTransaction();
    }

    protected function tearDown(): void
    {
        // Revertir los cambios realizados durante la transacción
        DB::rollBack();
        parent::tearDown();
    }

    /**
     * Test: Verificar que un cliente puede ser eliminado correctamente.
     */
    public function test_cliente_puede_ser_eliminado(): void
    {
        // Crea un cliente en la base de datos
        $cliente = Cliente::create([
            'nombre' => 'Juan Pérez',
            'correo_electronico' => 'juan@ejemplo.com',
            'telefono' => '123456789',
        ]);

        // Verifica que el cliente existe en la base de datos
        $this->assertDatabaseHas('clientes', [
            'id' => $cliente->id,
        ]);

        // Elimina el cliente
        $cliente->delete();

        // Verifica que el cliente ya no existe en la base de datos
        $this->assertDatabaseMissing('clientes', [
            'id' => $cliente->id,
        ]);
    }
}
