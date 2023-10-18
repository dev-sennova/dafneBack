<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbModeloCanvasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_modelo_canvas', function (Blueprint $table) {
            $table->id();
            $table->string('proposicion', 1200)->nullable();
            $table->string('segmento', 1200)->nullable();
            $table->string('relaciones', 1200)->nullable();
            $table->string('canales', 1200)->nullable();
            $table->string('actividades', 1200)->nullable();
            $table->string('recursos', 1200)->nullable();
            $table->string('aliados', 1200)->nullable();
            $table->string('flujos', 1200)->nullable();
            $table->string('estructura', 1200)->nullable();
            $table->integer('avancepro')->default(0);
            $table->integer('avanceseg')->default(0);
            $table->integer('avancerel')->default(0);
            $table->integer('avancecan')->default(0);
            $table->integer('avanceact')->default(0);
            $table->integer('avancerec')->default(0);
            $table->integer('avanceali')->default(0);
            $table->integer('avanceflu')->default(0);
            $table->integer('avanceest')->default(0);
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
        Schema::dropIfExists('tb_modelo_canvas');
    }
}
