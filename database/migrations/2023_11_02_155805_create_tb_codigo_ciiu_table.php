<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbCodigoCiiuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_codigo_ciiu', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 1024);
            $table->string('codigo');
            $table->foreignId('idriesgo')->constrained('tb_riesgo_arl');
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
        Schema::dropIfExists('tb_codigo_ciiu');
    }
}
