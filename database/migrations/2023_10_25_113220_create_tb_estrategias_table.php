<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbEstrategiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_estrategias', function (Blueprint $table) {
            $table->id();
            $table->string('accionFO', 700)->nullable();
            $table->string('accionDO', 700)->nullable();
            $table->string('accionFA', 700)->nullable();
            $table->string('accionDA', 700)->nullable();
            $table->string('estrategiaFO', 700)->nullable();
            $table->string('estrategiaDO', 700)->nullable();
            $table->string('estrategiaFA', 700)->nullable();
            $table->string('estrategiaDA', 700)->nullable();
            $table->integer('avanceFO')->default(0);
            $table->integer('avanceDO')->default(0);
            $table->integer('avanceFA')->default(0);
            $table->integer('avanceDA')->default(0);
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
        Schema::dropIfExists('tb_estrategias');
    }
}
