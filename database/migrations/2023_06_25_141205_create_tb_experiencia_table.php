<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbExperienciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_experiencia', function (Blueprint $table) {
            $table->id();
            $table->string('experiencia');
            $table->string('actividades');
            $table->string('area');
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
        Schema::dropIfExists('tb_experiencia');
    }
}
