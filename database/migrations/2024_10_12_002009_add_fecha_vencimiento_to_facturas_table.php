<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFechaVencimientoToFacturasTable extends Migration
{
    public function up()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->date('fecha_vencimiento')->after('monto'); // Ajusta la posición según sea necesario
        });
    }

    public function down()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropColumn('fecha_vencimiento'); // Elimina la columna si se revierte
        });
    }
}
