<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstadoToFacturasTable extends Migration
{
    public function up()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->string('estado')->after('fecha_vencimiento'); // Ajusta la posición según sea necesario
        });
    }

    public function down()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropColumn('estado'); // Elimina la columna si se revierte
        });
    }
}
