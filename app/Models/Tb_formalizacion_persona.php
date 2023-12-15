<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_formalizacion_persona extends Model
{
    //
    protected $table = 'tb_formalizacion_persona';

    protected $fillable = ['nombre','marca','codigoCiiu','usoDeSuelo','direccion','rut','rues','sayco','bomberil','placa',
    //'seguridad','afiliacion',
    'pasosAvance','idUsuario','estado'];

    public $timestamps = false;
}
