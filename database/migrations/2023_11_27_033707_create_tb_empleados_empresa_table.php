<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbEmpleadosEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_empleados_empresa', function (Blueprint $table) {
            $table->id();
            $table->string('empleado', 512);
            $table->integer('produccion')->default(0);
            $table->foreignId('idRiesgo')->constrained('tb_riesgo_arl');
            $table->foreignId('idPerfil')->constrained('tb_perfiles_empresa');
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
        Schema::dropIfExists('tb_empleados_empresa');
    }
}
