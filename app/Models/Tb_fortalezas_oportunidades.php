<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_fortalezas_oportunidades extends Model
{
    protected $table = 'tb_fortalezas_oportunidades';

    protected $fillable = ['accion','estrategia','estado','idUsuario'];

    public $timestamps = false;
}
