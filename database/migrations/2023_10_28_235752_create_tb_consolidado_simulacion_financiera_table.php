<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbConsolidadoSimulacionFinancieraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_consolidado_simulacion_financiera', function (Blueprint $table) {
            $table->id();
            $table->integer('producto')->default(0);
            $table->string('nombreProducto', 512)->nullable();
            $table->string('descripcionProducto', 512)->nullable();
            $table->string('nombreEmpresa', 512)->nullable();
            $table->integer('cantidadProducto')->default(0);
            $table->double('costoMateriales')->default(0);
            $table->double('costoCompra')->default(0);
            $table->integer('personaNatural')->default(0);
            $table->string('codigoCiiu', 512)->nullable();
            $table->integer('nivelRiesgo')->default(1);
            $table->double('costosIndirectos')->default(0);
            $table->double('talentoHumano')->default(0);
            $table->double('valorPrestamo')->default(0);
            $table->double('valorGastos')->default(0);
            $table->double('margenGanancia')->default(0);
            $table->double('precioVenta')->default(0);
            $table->double('precioIva')->default(0);
            $table->double('puntoEquilibrio')->default(0);
            $table->double('ingresosAdicionales')->default(0);
            $table->double('ingresosOrdinarios')->default(0);
            $table->double('costoVentas')->default(0);
            $table->double('utilidadBruta')->default(0);
            $table->double('gastosOperacionales')->default(0);
            $table->double('utilidadOperacional')->default(0);
            $table->double('egresosAdicionales')->default(0);
            $table->double('utilidadPreImpuesto')->default(0);
            $table->integer('pasosAvance')->default(0);
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
        Schema::dropIfExists('tb_consolidado_simulacion_financiera');
    }
}
