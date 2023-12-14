<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFormalizacionPersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_formalizacion_persona', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 700)->nullable();
            $table->text('marca', 2000)->nullable();
            $table->text('codigoCiiu', 2000)->nullable();
            $table->text('usoDeSuelo', 2000)->nullable();
            $table->text('direccion', 2000)->nullable();
            $table->text('rut', 2000)->nullable();
            $table->text('rues', 2000)->nullable();
            $table->text('sayco', 2000)->nullable();
            $table->text('bomberil', 2000)->nullable();
            $table->text('placa', 2000)->nullable();
            $table->text('seguridad', 2000)->nullable();
            $table->text('afiliacion', 2000)->nullable();
            $table->integer('pasosAvance')->default(0);
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
        Schema::dropIfExists('tb_formalizacion_persona');
    }
}
