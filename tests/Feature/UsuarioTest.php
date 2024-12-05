<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsuarioTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_puede_ser_creado()
    {
        $usuario = Usuario::create([
            'nombre' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'contrasena' => bcrypt('contrasena123'), // Cifra la contraseña
        ]);

        $this->assertDatabaseHas('usuarios', [
            'email' => 'juan@example.com',
        ]);
    }

    public function test_usuario_no_puede_registrarse_con_email_existente()
    {
        Usuario::create([
            'nombre' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'contrasena' => bcrypt('contrasena123'),
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Usuario::create([
            'nombre' => 'Pedro Pérez',
            'email' => 'juan@example.com',
            'contrasena' => bcrypt('contrasena456'),
        ]);
    }

   
    public function test_usuario_no_puede_iniciar_sesion_con_contrasena_incorrecta()
    {
        Usuario::create([
            'nombre' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'contrasena' => bcrypt('contrasena123'), // Cifra la contraseña
        ]);

        $this->assertFalse(\Auth::attempt(['email' => 'juan@example.com', 'contrasena' => 'contrasena_incorrecta']));
    }
}
