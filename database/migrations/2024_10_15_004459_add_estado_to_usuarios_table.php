<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstadoToUsuariosTable extends Migration
{
    public function up()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Verificar si la columna 'estado' no existe antes de agregarla
            if (!Schema::hasColumn('usuarios', 'estado')) {
                $table->boolean('estado')->default(false); // Agregar el campo estado
            }
        });
    }

    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Verificar si la columna 'estado' existe antes de eliminarla
            if (Schema::hasColumn('usuarios', 'estado')) {
                $table->dropColumn('estado'); // Eliminar el campo estado si se revierte la migración
            }
        });
    }
}
