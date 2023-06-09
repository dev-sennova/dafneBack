<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbCriteriosEvaluacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_criterios_evaluacion', function (Blueprint $table) {
            $table->id();
            $table->string('ideas');
            $table->boolean('visibilidad')->default(0); //visibilidad 1 nueva, 0 original
            $table->foreignId('idideas')->constrained('tb_ideas');
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
        Schema::dropIfExists('tb_criterios_evaluacion');
    }
}
