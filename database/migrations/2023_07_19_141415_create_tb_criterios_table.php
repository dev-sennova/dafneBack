<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbCriteriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_criterios', function (Blueprint $table) {
            $table->id();
            $table->string('criterio');
            $table->boolean('visibilidad')->default(0); //visibilidad 1 obligatoria, 0 opcional
            $table->boolean('moderacion')->default(0); //moderacion 0 espera, 1 moderado
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
        Schema::dropIfExists('tb_criterios');
    }
}
