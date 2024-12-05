<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveNotificacionIdFromNotificacionesUsuariosTable extends Migration
{
    public function up()
    {
        Schema::table('notificaciones_usuarios', function (Blueprint $table) {
            // Eliminar la clave foránea
            $table->dropForeign('notificaciones_usuario_notificacion_id_foreign');
            // Eliminar la columna
            $table->dropColumn('notificacion_id');
        });
    }

    public function down()
    {
        Schema::table('notificaciones_usuarios', function (Blueprint $table) {
            // Revertir la eliminación de la columna
            $table->unsignedBigInteger('notificacion_id')->nullable();
            // Reestablecer la clave foránea
            $table->foreign('notificacion_id')->references('id')->on('notificaciones')->onDelete('restrict');
        });
    }
}
