<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ClienteTestF extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear un usuario para autenticación
        $this->user = User::factory()->create([
            'password' => Hash::make('password'), // Contraseña del usuario
        ]);
    }

    /** @test */
    public function un_usuario_autenticado_puede_ver_la_lista_de_clientes()
    {
        $response = $this->actingAs($this->user)->get(route('clientes.index'));

        $response->assertStatus(200); // Asegúrate de que el status sea 200
    }

    /** @test */
    public function un_usuario_autenticado_puede_ver_el_formulario_para_crear_un_cliente()
    {
        $response = $this->actingAs($this->user)->get(route('clientes.create'));

        $response->assertStatus(200); // Asegúrate de que el status sea 200
    }

    /** @test */
    public function un_usuario_autenticado_puede_crear_un_cliente()
    {
        $clienteData = [
            'nombre' => 'Juan Perez',
            'correo_electronico' => 'juan@example.com',
            'telefono' => '123456789',
            'direccion' => 'Calle Falsa 123',
        ];

        $response = $this->actingAs($this->user)->post(route('clientes.store'), $clienteData);

        $response->assertRedirect(route('clientes.index')); // Asegúrate de que redirija al índice
        $this->assertDatabaseHas('clientes', $clienteData); // Verifica que el cliente se haya creado en la base de datos
    }

    /** @test */
    public function un_usuario_no_autenticado_no_puede_acceder_a_las_rutas_de_clientes()
    {
        $response = $this->get(route('clientes.index'));

        $response->assertRedirect('/login'); // Asegúrate de que redirija al login
    }

    /** @test */
    public function un_usuario_autenticado_puede_ver_detalle_de_cliente()
    {
        $cliente = Cliente::factory()->create(); // Crea un cliente

        $response = $this->actingAs($this->user)->get(route('clientes.show', $cliente));

        $response->assertStatus(200); // Asegúrate de que el status sea 200
    }

    /** @test */
    public function un_usuario_autenticado_puede_ver_el_formulario_para_editar_un_cliente()
    {
        $cliente = Cliente::factory()->create(); // Crea un cliente

        $response = $this->actingAs($this->user)->get(route('clientes.edit', $cliente));

        $response->assertStatus(200); // Asegúrate de que el status sea 200
    }

    /** @test */
    public function un_usuario_autenticado_puede_actualizar_un_cliente()
    {
        $cliente = Cliente::factory()->create(); // Crea un cliente

        $clienteData = [
            'nombre' => 'Juanito Perez',
            'correo_electronico' => 'juanito@example.com',
            'telefono' => '987654321',
            'direccion' => 'Calle Verdadera 456',
        ];

        $response = $this->actingAs($this->user)->put(route('clientes.update', $cliente), $clienteData);

        $response->assertRedirect(route('clientes.index')); // Asegúrate de que redirija al índice
        $this->assertDatabaseHas('clientes', $clienteData); // Verifica que el cliente se haya actualizado en la base de datos
    }

    /** @test */
    public function un_usuario_autenticado_puede_eliminar_un_cliente()
    {
        $cliente = Cliente::factory()->create(); // Crea un cliente

        $response = $this->actingAs($this->user)->delete(route('clientes.destroy', $cliente));

        $response->assertRedirect(route('clientes.index')); // Asegúrate de que redirija al índice
        $this->assertDeleted($cliente); // Verifica que el cliente se haya eliminado de la base de datos
    }
}
