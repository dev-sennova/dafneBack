<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_fortalezas_amenazas extends Model
{
    protected $table = 'tb_fortalezas_amenazas';

    protected $fillable = ['accion','estrategia','estado','idUsuario'];

    public $timestamps = false;
}
