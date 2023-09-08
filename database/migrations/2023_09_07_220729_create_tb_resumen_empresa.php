<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbResumenEmpresa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_resumen_empresa', function (Blueprint $table) {
            $table->id();
            $table->string('nombreIdea');
            $table->foreignId('idUsuario')->constrained('tb_usuario');
            $table->string('nombreEmpresa')->nullable();
            $table->string('mision')->nullable();
            $table->string('vision')->nullable();
            $table->string('slogan')->nullable();
            $table->string('logo')->nullable();
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
        Schema::dropIfExists('tb_resumen_empresa');
    }
}
