<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbCriteriosEvaluacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_criterios_evaluacion', function (Blueprint $table) {
            $table->id();
            $table->float('porcentaje',3,2)->default(0.00);
            $table->foreignId('idCriterio')->constrained('tb_usuario_criterios');
            $table->foreignId('idIdea')->constrained('tb_ideas');
            $table->foreignId('idUsuario')->constrained('tb_usuario');
            $table->boolean('estado')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_criterios_evaluacion');
    }
}
