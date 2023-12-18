<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbDirectorioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_directorio', function (Blueprint $table) {
            $table->id();
            $table->string('entidad');
            $table->string('municipio');
            $table->string('direccion');
            $table->string('web');
            $table->string('telefonos');
            $table->string('chat');
            $table->string('correo');
            $table->string('tipo');
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
        Schema::dropIfExists('tb_directorio');
    }
}
