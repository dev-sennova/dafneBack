<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbResumenSimulacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_resumen_simulacion', function (Blueprint $table) {
            $table->id();
            $table->integer('idExterno');
            $table->string('cadena', 512);
            $table->boolean('pregunta')->default(0);
            $table->boolean('enunciado')->default(0);
            $table->boolean('enlace')->default(0);
            $table->integer('seccion')->default(0);
            $table->integer('estado')->default(0);
            $table->foreignId('idUsuario')->constrained('tb_usuario');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_resumen_simulacion');
    }
}
