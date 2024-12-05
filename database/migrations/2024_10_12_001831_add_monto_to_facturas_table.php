<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMontoToFacturasTable extends Migration
{
    public function up()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->decimal('monto', 10, 2)->after('cliente_id'); // Ajusta el tipo de dato y posición según sea necesario
        });
    }

    public function down()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropColumn('monto'); // Elimina la columna si se revierte
        });
    }
}
