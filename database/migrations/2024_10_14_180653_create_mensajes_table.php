<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMensajesTable extends Migration
{
    public function up()
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('remitente_id');
            $table->unsignedBigInteger('receptor_id');
            $table->text('mensaje');
            $table->timestamps();

            // Asegúrate de que estas referencias sean correctas
            $table->foreign('remitente_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('receptor_id')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mensajes');
    }
}
