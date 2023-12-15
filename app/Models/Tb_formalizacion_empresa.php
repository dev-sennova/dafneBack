<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_formalizacion_empresa extends Model
{
    //
    protected $table = 'tb_formalizacion_empresa';

    protected $fillable = ['razonSocial','marca','ciiu','direccion','usoDeSuelo','rut','rutEmpresa','estatutos','acta','sociedad','impuestoRegistro','rues','libros','sayco','bomberil','placa','pasosAvance','idUsuario','estado'];

    public $timestamps = false;
}
