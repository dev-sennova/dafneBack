<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbHobbiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_hobbies', function (Blueprint $table) {
            $table->id();
            $table->string('hobby');
            $table->boolean('visibilidad')->default(0); //visibilidad 1 obligatoria, 0 opcional
            $table->boolean('moderacion')->default(0); //moderacion 0 espera, 1 moderado
            $table->boolean('estado')->default(1);
            $table->timestamp('created_at')->nullable(); 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_hobbies');
    }
}
