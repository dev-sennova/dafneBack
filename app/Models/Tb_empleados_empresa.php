<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_empleados_empresa extends Model
{
    //
    protected $table = 'tb_empleados_empresa';

    protected $fillable = ['empleado','produccion','idRiesgo','idPerfil','idUsuario','estado'];

    public $timestamps = false;
}
