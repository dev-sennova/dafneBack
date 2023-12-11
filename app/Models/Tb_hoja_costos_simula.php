<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_hoja_costos_simula extends Model
{
    //
   protected $table = 'tb_hoja_costos_simula';

   protected $fillable = ['detalle','monto','capacidad','montounidad','producto','talento','cif','idUsuario','estado'];

   public $timestamps = false;
}
