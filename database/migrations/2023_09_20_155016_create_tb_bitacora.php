<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbBitacora extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_bitacora', function (Blueprint $table) {
            $table->id();
            $table->integer('avance')->default(0);
            $table->foreignId('idSeccion')->constrained('tb_secciones');
            $table->foreignId('idUsuario')->constrained('tb_usuario');
            //$table->integer('valorMinuto')->unsigned();
            //$table->boolean('estado')->default(1);
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
        Schema::dropIfExists('tb_bitacora');
    }
}
