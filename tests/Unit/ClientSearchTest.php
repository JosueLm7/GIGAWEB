<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

class ClientSearchTest extends TestCase
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

    public function test_buscar_cliente_por_nombre()
    {
        // Crear un cliente para la prueba
        $cliente = Cliente::create([
            'nombre' => 'Juan Perez',
            'correo_electronico' => 'juan@example.com',
            'telefono' => '123456789',
            'direccion' => 'Calle Falsa 123',
        ]);

        // Simula la búsqueda
        $resultado = Cliente::where('nombre', 'Juan Perez')->first();

        // Verifica que el cliente se haya encontrado
        $this->assertNotNull($resultado);
        $this->assertEquals($cliente->id, $resultado->id);
    }

    public function test_no_encontrar_cliente_inexistente()
    {
        // Intentar buscar un cliente que no existe
        $resultado = Cliente::where('nombre', 'No Existe')->first();

        // Verifica que no se haya encontrado
        $this->assertNull($resultado);
    }
}
