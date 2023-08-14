<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbRelacionIdeasCriteriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_relacion_ideas_criterios', function (Blueprint $table) {
            $table->id();
            $table->integer('porcentaje')->default(0);
            $table->foreignId('idUsuarioIdeas')->constrained('tb_usuario_ideas');
            $table->foreignId('idUsuarioCriterios')->constrained('tb_usuario_criterios');
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
        Schema::dropIfExists('tb_relacion_ideas_criterios');
    }
}
