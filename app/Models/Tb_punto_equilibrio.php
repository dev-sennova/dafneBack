<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_punto_equilibrio extends Model
{
    //
    protected $table = 'tb_punto_equilibrio';

    protected $fillable = ['costosGastos','precioVentaSinIva','productosInsumos','idUsuario','estado'];

    public $timestamps = false;
}
