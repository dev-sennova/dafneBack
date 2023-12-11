<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_hoja_gastos_simula extends Model
{
    //
   protected $table = 'tb_hoja_gastos_simula';

   protected $fillable = ['detalle','monto','financieros','adicionales','idUsuario','estado'];

   public $timestamps = false;
}
