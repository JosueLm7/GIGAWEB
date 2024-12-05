<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyFechaColumnInFacturasTable extends Migration
{
    public function up()
    {
        Schema::table('facturas', function (Blueprint $table) {
            // Cambia el tipo de columna si es necesario
            $table->dateTime('fecha')->default(now())->change();
        });
    }

    public function down()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->dateTime('fecha')->nullable()->change(); // Restaurar a nullable si es necesario
        });
    }
}
