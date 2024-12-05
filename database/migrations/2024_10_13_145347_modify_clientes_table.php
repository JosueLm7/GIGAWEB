<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyClientesTable extends Migration
{
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            // Agregar columnas solo si no existen
            if (!Schema::hasColumn('clientes', 'nombres')) {
                $table->string('nombres')->after('id');
            }
            if (!Schema::hasColumn('clientes', 'apellido_paterno')) {
                $table->string('apellido_paterno')->after('nombres');
            }
            if (!Schema::hasColumn('clientes', 'apellido_materno')) {
                $table->string('apellido_materno')->after('apellido_paterno');
            }

            // Eliminar columna "nombre" solo si existe
            if (Schema::hasColumn('clientes', 'nombre')) {
                $table->dropColumn('nombre');
            }
        });
    }

    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            // Eliminar columnas agregadas en 'up' si existen
            if (Schema::hasColumn('clientes', 'nombres')) {
                $table->dropColumn('nombres');
            }
            if (Schema::hasColumn('clientes', 'apellido_paterno')) {
                $table->dropColumn('apellido_paterno');
            }
            if (Schema::hasColumn('clientes', 'apellido_materno')) {
                $table->dropColumn('apellido_materno');
            }

            // Reagregar columna "nombre" solo si no existe
            if (!Schema::hasColumn('clientes', 'nombre')) {
                $table->string('nombre')->after('id');
            }
        });
    }
}