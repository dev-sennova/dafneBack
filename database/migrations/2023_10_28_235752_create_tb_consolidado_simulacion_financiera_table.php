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
            $table->string('nombreProducto', 512);
            $table->string('cantidadProducto', 512);
            $table->string('costoMateriales', 512);
            $table->string('costoVenta', 512);
            $table->string('costoMaterialesUnidad', 512);
            $table->string('codigoCiiu', 512);
            $table->string('perfilTalento', 512);
            $table->string('valorMensualPerfil', 512);
            $table->string('perfilesCreados', 512);
            $table->string('vidaUtil', 512);
            $table->string('valorMensual', 512);
            $table->string('costosIndirectos', 512);
            $table->string('valorPrestamo', 512);
            $table->string('valorConcepto', 512);
            $table->string('ventas', 512);
            $table->string('margenGanancia', 512);
            $table->string('capturaDatos', 512);

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
