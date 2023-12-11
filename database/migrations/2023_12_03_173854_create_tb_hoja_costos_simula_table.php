<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbHojaCostosSimulaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_hoja_costos_simula', function (Blueprint $table) {
            $table->id();
            $table->string('detalle', 512);
            $table->double('monto')->default(0);
            $table->double('capacidad')->default(0);
            $table->double('montounidad')->default(0);
            $table->integer('producto')->default(1);
            $table->integer('talento')->default(1);
            $table->integer('cif')->default(1);
            $table->foreignId('idUsuario')->constrained('tb_usuario');
            $table->boolean('estado')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_hoja_costos_simula');
    }
}
