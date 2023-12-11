<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_estado_resultados_simula extends Model
{
    //
   protected $table = 'tb_estado_resultados_simula';

   protected $fillable = ['detalle','valor','porcentaje','idUsuario','estado'];

   public $timestamps = false;
}
