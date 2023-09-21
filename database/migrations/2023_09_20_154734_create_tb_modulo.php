<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbModulo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_modulo', function (Blueprint $table) {
            $table->id();
            $table->string('modulo', 255);
            //$table->foreignId('idProceso')->constrained('tb_proceso');
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
        Schema::dropIfExists('tb_modulo');
    }
}
