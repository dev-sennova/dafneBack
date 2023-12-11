<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_gastos_adicionales extends Model
{
    //
    protected $table = 'tb_gastos_adicionales';

    protected $fillable = ['concepto','valor','idUsuario','estado'];

    public $timestamps = false;
}
