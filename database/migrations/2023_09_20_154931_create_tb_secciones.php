<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbSecciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_secciones', function (Blueprint $table) {
            $table->id();
            $table->string('seccion', 255);
            $table->foreignId('idModulo')->constrained('tb_modulo');
            //$table->integer('valorMinuto')->unsigned();
            //$table->boolean('estado')->default(1);
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
        Schema::dropIfExists('tb_secciones');
    }
}
