<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMensajeToNotificacionesUsuariosTable extends Migration
{
    public function up()
    {
        Schema::table('notificaciones_usuarios', function (Blueprint $table) {
            $table->string('mensaje'); // Agrega la columna mensaje
        });
    }

    public function down()
    {
        Schema::table('notificaciones_usuarios', function (Blueprint $table) {
            $table->dropColumn('mensaje'); // Elimina la columna en caso de revertir la migración
        });
    }
}
