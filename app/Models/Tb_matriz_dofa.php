<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_matriz_dofa extends Model
{
    protected $table = 'tb_matriz_dofa';

    protected $fillable = ['debilidades','oportunidades','fortalezas','amenazas','avanced','avanceo','avancef','avancea','estado','idUsuario'];

    public $timestamps = false;
}
