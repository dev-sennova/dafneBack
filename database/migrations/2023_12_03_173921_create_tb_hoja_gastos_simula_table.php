<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbHojaGastosSimulaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_hoja_gastos_simula', function (Blueprint $table) {
            $table->id();
            $table->string('detalle', 512);
            $table->double('monto')->default(0);
            $table->integer('financieros')->default(1);
            $table->integer('adicionales')->default(1);
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
        Schema::dropIfExists('tb_hoja_gastos_simula');
    }
}
