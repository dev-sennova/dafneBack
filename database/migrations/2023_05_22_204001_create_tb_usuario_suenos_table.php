<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbUsuarioSuenosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_usuario_suenos', function (Blueprint $table) {
            $table->id();
            $table->integer('prioridad');
            $table->foreignId('idUsuario')->constrained('tb_usuario');
            $table->foreignId('idSuenos')->constrained('tb_suenos');
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
        Schema::dropIfExists('tb_usuario_suenos');
    }
}
