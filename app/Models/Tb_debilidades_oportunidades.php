<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_debilidades_oportunidades extends Model
{
    protected $table = 'tb_debilidades_oportunidades';

    protected $fillable = ['accion','estrategia','estado','idUsuario'];

    public $timestamps = false;
}
