<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_secciones extends Model
{
    protected $table = 'tb_secciones';

    protected $fillable = ['seccion','idModulo'];

    public $timestamps = false;
}
