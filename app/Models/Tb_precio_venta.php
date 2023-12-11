<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_precio_venta extends Model
{
    //
    protected $table = 'tb_precio_venta';

    protected $fillable = ['costo','margen','venta','impuesto','valorimpuesto','idUsuario','estado'];

    public $timestamps = false;
}
