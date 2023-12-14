<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPrecioVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_precio_venta', function (Blueprint $table) {
            $table->id();
            $table->double('costo')->default(0);
            $table->float('margen')->default(0);
            $table->double('venta')->default(0);
            $table->double('impuesto')->default(0);
            $table->double('valorimpuesto')->default(0);
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
        Schema::dropIfExists('tb_precio_venta');
    }
}
