<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_estrategias extends Model
{
    protected $table = 'tb_estrategias';

    protected $fillable = ['accionFO','accionDO','accionFA','accionDA','estrategiaFO','estrategiaDO','estrategiaFA','estrategiaDA','
    avanceFO','avanceDO','avanceFA','avanceDA','estado','idUsuario'];

    public $timestamps = false;
}
