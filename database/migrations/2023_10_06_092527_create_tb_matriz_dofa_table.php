<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbMatrizDofaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_matriz_dofa', function (Blueprint $table) {
            $table->id();
            $table->string('debilidades1', 1200)->nullable();
            $table->string('oportunidades1', 1200)->nullable();
            $table->string('fortalezas1', 1200)->nullable();
            $table->string('amenazas1', 1200)->nullable();
            $table->string('debilidades2', 1200)->nullable();
            $table->string('oportunidades2', 1200)->nullable();
            $table->string('fortalezas2', 1200)->nullable();
            $table->string('amenazas2', 1200)->nullable();
            $table->string('debilidades3', 1200)->nullable();
            $table->string('oportunidades3', 1200)->nullable();
            $table->string('fortalezas3', 1200)->nullable();
            $table->string('amenazas3', 1200)->nullable();
            $table->string('debilidades4', 1200)->nullable();
            $table->string('oportunidades4', 1200)->nullable();
            $table->string('fortalezas4', 1200)->nullable();
            $table->string('amenazas4', 1200)->nullable();
            $table->integer('avanced')->default(0);
            $table->integer('avanceo')->default(0);
            $table->integer('avancef')->default(0);
            $table->integer('avancea')->default(0);
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
        Schema::dropIfExists('tb_matriz_dofa');
    }
}
