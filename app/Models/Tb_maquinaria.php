<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_maquinaria extends Model
{
    //
    protected $table = 'tb_maquinaria';

    protected $fillable = ['maquinaria','valor','vidaUtil','depreciacion','idUsuario','estado'];

    public $timestamps = false;
}
