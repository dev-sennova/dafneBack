<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbAvancesSimulacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_avances_simulacion', function (Blueprint $table) {
            $table->id();
            $table->string('cadena', 255);
            $table->boolean('pregunta')->default(0);
            $table->boolean('enunciado')->default(0);
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
        Schema::dropIfExists('tb_avances_simulacion');
    }
}
