<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_matriz_dofa extends Model
{
    protected $table = 'tb_matriz_dofa';

    protected $fillable = ['debilidades1','oportunidades1','fortalezas1','amenazas1','debilidades2','oportunidades2','fortalezas2','amenazas2','
    debilidades3','oportunidades3','fortalezas3','amenazas3','debilidades4','oportunidades4','fortalezas4','amenazas4','avanced','avanceo',
    'avancef','avancea','estado','idUsuario'];

    public $timestamps = false;
}
