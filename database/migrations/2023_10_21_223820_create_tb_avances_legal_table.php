<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbAvancesLegalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_avances_legal', function (Blueprint $table) {
            $table->id();
            $table->integer('idExterno');
            $table->string('cadena', 512);
            $table->boolean('pregunta')->default(0);
            $table->boolean('enunciado')->default(0);
            $table->boolean('enlace')->default(0);
            $table->integer('next')->default(0);
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
        Schema::dropIfExists('tb_avances_legal');
    }
}
