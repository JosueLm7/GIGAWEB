<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameNotificacionesUsuarioToNotificacionesUsuarios extends Migration
{
    public function up()
    {
        Schema::rename('notificaciones_usuario', 'notificaciones_usuarios');
    }

    public function down()
    {
        Schema::rename('notificaciones_usuarios', 'notificaciones_usuario');
    }
}
