<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

class ClienteTest extends TestCase
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

    public function test_cliente_creado_correctamente()
    {
        $cliente = Cliente::create([
            'nombre' => 'Juan Perez',
            'correo_electronico' => 'juan@example.com',
            'telefono' => '123456789',
            'direccion' => 'Calle Falsa 123',
        ]);

        $this->assertDatabaseHas('clientes', [
            'nombre' => 'Juan Perez',
            'correo_electronico' => 'juan@example.com',
        ]);
    }

    public function test_correo_electronico_unico()
    {
        Cliente::create([
            'nombre' => 'Juan Perez',
            'correo_electronico' => 'juan@example.com',
            'telefono' => '123456789',
            'direccion' => 'Calle Falsa 123',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Cliente::create([
            'nombre' => 'Maria Lopez',
            'correo_electronico' => 'juan@example.com', // El mismo correo
            'telefono' => '987654321',
            'direccion' => 'Calle Verdadera 456',
        ]);
    }
}
