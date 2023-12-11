<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFinanciacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_financiacion', function (Blueprint $table) {
            $table->id();
            $table->integer('valor')->default(0);
            $table->boolean('anual')->default(0);
            $table->double('tasaAnual')->default(0);
            $table->double('tasaMensual')->default(0);
            $table->integer('cantidadPeriodos')->default(1);
            $table->double('cuota')->default(0);
            $table->integer('periodo')->default(1);
            $table->double('capitalInicial')->default(0);
            $table->double('interes')->default(0);
            $table->double('amortizacion')->default(0);
            $table->double('saldo')->default(0);
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
        Schema::dropIfExists('tb_financiacion');
    }
}
