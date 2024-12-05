<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCorreoElectronicoToClientesTable extends Migration
{
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            // Asegúrate de que no se intente agregar 'correo_electronico' si ya existe
            if (!Schema::hasColumn('clientes', 'correo_electronico')) {
                $table->string('correo_electronico')->unique()->after('nombre');
            }

            // Si es necesario eliminar 'email', asegúrate de que exista
            if (Schema::hasColumn('clientes', 'email')) {
                $table->dropColumn('email');
            }
        });
    }

    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            // Si se revierte, elimina 'correo_electronico' solo si existe
            if (Schema::hasColumn('clientes', 'correo_electronico')) {
                $table->dropColumn('correo_electronico');
            }

            // Si necesitas reintroducir 'email', agrégala solo si no existe
            if (!Schema::hasColumn('clientes', 'email')) {
                $table->string('email')->unique()->after('nombre');
            }
        });
    }
}
