<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_route_is_accessible()
    {
        $response = $this->get('/login');

        $response->assertStatus(200); // Verifica que la respuesta sea 200 OK
        $response->assertSee('Iniciar Sesión'); // Verifica que el texto esté presente
    }

    public function test_login_with_valid_credentials()
    {
        $this->withoutMiddleware(); // Agrega esto para omitir el CSRF

        // Crea el usuario
        $usuario = Usuario::create([
            'nombre' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'contrasena' => bcrypt('contrasena123'),
        ]);

        // Intenta iniciar sesión
        $response = $this->post('/login', [
            'email' => 'juan@example.com',
            'contrasena' => 'contrasena123',
        ]);

        $response->assertRedirect('/'); // Cambia a la ruta a la que rediriges después del login
        $this->assertAuthenticatedAs($usuario); // Verifica que el usuario esté autenticado
    }



    public function test_login_with_invalid_credentials()
    {
        $this->withoutMiddleware(); // Agrega esto para omitir el CSRF

        // Intenta iniciar sesión con credenciales inválidas
        $response = $this->post('/login', [
            'email' => 'wrong@example.com',
            'contrasena' => 'incorrecta',
        ]);

        $response->assertSessionHasErrors(['email']); // Verifica que hay errores en la sesión para el campo email
        $this->assertGuest(); // Verifica que nadie esté autenticado
    }

}
