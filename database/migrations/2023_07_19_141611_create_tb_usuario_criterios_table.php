<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbUsuarioCriteriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_usuario_criterios', function (Blueprint $table) {
            $table->id();
            $table->integer('porcentaje')->default(0);
            $table->foreignId('idUsuario')->constrained('tb_usuario');
            $table->foreignId('idCriterio')->constrained('tb_criterios');
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
        Schema::dropIfExists('tb_usuario_criterios');
    }
}
