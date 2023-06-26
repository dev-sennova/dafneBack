<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbOcupacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_ocupacion', function (Blueprint $table) {
            $table->id();
            $table->string('ocupacion');
            $table->string('lugar');
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
        Schema::dropIfExists('tb_ocupacion');
    }
}
