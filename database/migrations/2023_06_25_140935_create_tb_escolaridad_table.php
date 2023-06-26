<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbEscolaridadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_escolaridad', function (Blueprint $table) {
            $table->id();
            $table->string('escolaridad');
            $table->string('nivelescolaridad');
            $table->string('areaconocimiento');
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
        Schema::dropIfExists('tb_escolaridad');
    }
}
