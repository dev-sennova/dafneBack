<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFormalizacionEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_formalizacion_empresa', function (Blueprint $table) {
            $table->id();
            $table->string('razonSocial', 700)->nullable();
            $table->longtext('marca')->nullable();
            $table->text('ciiu', 2000)->nullable();
            $table->text('direccion', 2000)->nullable();
            $table->longtext('usoDeSuelo')->nullable();
            $table->longtext('rut')->nullable();
            $table->longtext('rutEmpresa')->nullable();
            $table->longtext('estatutos')->nullable();
            $table->longtext('acta')->nullable();
            $table->longtext('sociedad')->nullable();
            $table->longtext('impuestoRegistro')->nullable();
            $table->longtext('rues')->nullable();
            $table->longtext('libros')->nullable();
            $table->longtext('sayco')->nullable();
            $table->longtext('bomberil')->nullable();
            $table->text('placa', 2000)->nullable();
            $table->integer('pasosAvance')->default(0);
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
        Schema::dropIfExists('tb_formalizacion_empresa');
    }
}
