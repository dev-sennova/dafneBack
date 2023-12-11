<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbNominaEmpleadosSimulaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_nomina_empleados_simula', function (Blueprint $table) {
            $table->id();
            $table->string('perfil', 512);
            $table->double('valor')->default(0);
            $table->double('auxilio')->default(0);
            $table->double('salud')->default(0);
            $table->double('pension')->default(0);
            $table->double('arl')->default(0);
            $table->double('caja')->default(0);
            $table->double('sena')->default(0);
            $table->double('icbf')->default(0);
            $table->double('prima')->default(0);
            $table->double('cesantias')->default(0);
            $table->double('vacaciones')->default(0);
            $table->double('intereses')->default(0);
            $table->double('costomensual')->default(0);
            $table->integer('productiva')->default(1);
            $table->foreignId('idUsuario')->constrained('tb_usuario');
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
        Schema::dropIfExists('tb_nomina_empleados_simula');
    }
}
