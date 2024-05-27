<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbCiudadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_ciudad', function (Blueprint $table) {
            $table->id();
            $table->string('ciudad');
            $table->boolean('estado')->default(1);

            // Clave foránea para el ID del departamento
            $table->unsignedBigInteger('departamento_id');
            $table->foreign('departamento_id')->references('id')->on('tb_departamentos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_ciudad');
    }
}
