<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLeidaToNotificacionesUsuariosTable extends Migration
{
    public function up()
    {
        Schema::table('notificaciones_usuarios', function (Blueprint $table) {
            $table->boolean('leida')->default(false); // Agrega la columna leida
        });
    }

    public function down()
    {
        Schema::table('notificaciones_usuarios', function (Blueprint $table) {
            $table->dropColumn('leida'); // Elimina la columna en caso de revertir la migración
        });
    }
}
