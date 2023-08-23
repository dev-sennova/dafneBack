<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbMatrizEvaluacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_matriz_evaluacion', function (Blueprint $table) {
            $table->id();
            $table->float('porcentaje',3,2)->default(0.00);
            $table->foreignId('idUsuarioIdeas')->constrained('tb_usuario_ideas');
            $table->string('nombreIdea');
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
        Schema::dropIfExists('tb_matriz_evaluacion');
    }
}
