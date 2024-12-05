<?php

namespace Tests\Unit;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsuarioEmailTest extends TestCase
{
    use RefreshDatabase;

    public function test_insercion_de_usuario_con_email_valido()
    {
        // Definir un correo electrónico válido
        $emailValido = 'usuario@dominio.com';

        // Crear el usuario
        $usuario = Usuario::create([
            'nombre' => 'Juan Pérez',
            'email' => $emailValido,
            'contrasena' => bcrypt('contrasena123'),
        ]);

        // Comprobar que el usuario fue creado con el email correcto
        $this->assertEquals($emailValido, $usuario->email);
    }

    public function test_insercion_de_usuario_con_email_invalido()
    {
        // Definir un correo electrónico inválido
        $emailInvalido = 'usuario@dominio';

        // Probar que se lanza una excepción al intentar crear el usuario
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        // Intentar crear el usuario
        Usuario::crear([
            'nombre' => 'Juan Pérez',
            'email' => $emailInvalido,
            'contrasena' => bcrypt('contrasena123'),
        ]);
    }

}
