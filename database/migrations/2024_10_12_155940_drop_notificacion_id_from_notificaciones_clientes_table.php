<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropNotificacionIdFromNotificacionesClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notificaciones_clientes', function (Blueprint $table) {
            $table->dropForeign(['notificacion_id']); // Eliminar la clave foránea
            $table->dropColumn('notificacion_id'); // Luego eliminar la columna
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notificaciones_clientes', function (Blueprint $table) {
            $table->unsignedBigInteger('notificacion_id')->nullable(); // O especifica la definición que tenías antes
            $table->foreign('notificacion_id')->references('id')->on('notificaciones')->onDelete('cascade'); // Reagregar la clave foránea
        });
    }
}
