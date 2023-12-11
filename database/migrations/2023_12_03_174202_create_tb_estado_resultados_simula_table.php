<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbEstadoResultadosSimulaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_estado_resultados_simula', function (Blueprint $table) {
            $table->id();
            $table->string('detalle', 512);
            $table->double('valor')->default(0);
            $table->double('porcentaje')->default(0);
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
        Schema::dropIfExists('tb_estado_resultados_simula');
    }
}
