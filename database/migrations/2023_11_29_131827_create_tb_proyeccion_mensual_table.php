<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbProyeccionMensualTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_proyeccion_mensual', function (Blueprint $table) {
            $table->id();
            $table->float('ingresosActividadesOrdinarias', 2)->default(0);
            $table->float('costoVentas', 2)->default(0);
            $table->float('utilidadBruta', 2)->default(0);
            $table->float('gastosOperacionales', 2)->default(0);
            $table->float('utilidadOperacional', 2)->default(0);
            $table->float('otrosIngresos', 2)->default(0);
            $table->float('otrosEgresos', 2)->default(0);
            $table->float('utilidadAntesImpuesto', 2)->default(0);
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
        Schema::dropIfExists('tb_proyeccion_mensual');
    }
}
