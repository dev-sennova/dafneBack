<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_debilidades_amenazas extends Model
{
    protected $table = 'tb_debilidades_amenazas';

    protected $fillable = ['accion','estrategia','estado','idUsuario'];

    public $timestamps = false;
}
