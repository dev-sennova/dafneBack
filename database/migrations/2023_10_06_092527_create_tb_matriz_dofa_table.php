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
            $table->string('debilidades', 1200)->nullable();
            $table->string('oportunidades', 1200)->nullable();
            $table->string('fortalezas', 1200)->nullable();
            $table->string('amenazas', 1200)->nullable();
            $table->integer('avance')->default(0);
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
