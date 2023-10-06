<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_bitacora extends Model
{
    protected $table = 'tb_bitacora';

    protected $fillable = ['avance','idSeccion','idUsuario'];

    public $timestamps = false;
}
