<?php

namespace Tests\Unit;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsuarioAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_no_debe_tener_contrasena_en_json()
    {
        $usuario = Usuario::create([
            'nombre' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'contrasena' => bcrypt('contrasena123'),
        ]);

        // Verificar que la contraseña no está presente en la representación JSON
        $this->assertArrayNotHasKey('contrasena', $usuario->toArray());
    }

    public function test_usuario_no_debe_tener_contrasena_en_array()
    {
        $usuario = Usuario::create([
            'nombre' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'contrasena' => bcrypt('contrasena123'),
        ]);

        // Verificar que la contraseña no está presente en el array
        $this->assertArrayNotHasKey('contrasena', $usuario->toArray());
    }
}
