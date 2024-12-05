<?php

// database/migrations/YYYY_MM_DD_HHMMSS_create_notificaciones_usuario_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionesUsuarioTable extends Migration
{
    public function up()
    {
        Schema::create('notificaciones_usuario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios');
            $table->foreignId('notificacion_id')->constrained('notificaciones');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notificaciones_usuario');
    }
}
