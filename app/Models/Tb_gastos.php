<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_gastos extends Model
{
    //
    protected $table = 'tb_gastos';

    protected $fillable = ['gasto','valor','idUsuario','estado'];

    public $timestamps = false;
}
