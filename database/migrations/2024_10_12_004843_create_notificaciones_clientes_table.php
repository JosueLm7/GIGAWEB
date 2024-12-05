<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionesClientesTable extends Migration
{
    public function up()
    {
        Schema::create('notificaciones_clientes', function (Blueprint $table) {
            $table->id(); // Campo ID
            $table->foreignId('cliente_id')->constrained()->onDelete('cascade'); // Relación con clientes
            $table->foreignId('notificacion_id')->constrained('notificaciones')->onDelete('cascade'); // Relación con notificaciones
            $table->string('mensaje'); // Agregar columna mensaje
            $table->boolean('leida')->default(false); // Agregar columna leida
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('notificaciones_clientes');
    }
}
