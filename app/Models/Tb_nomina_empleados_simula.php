<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_nomina_empleados_simula extends Model
{
   //
   protected $table = 'tb_nomina_empleados_simula';

   protected $fillable = ['perfil','valor','auxilio','salud','pension','arl','caja','sena','icbf','prima','cesantias','vacaciones',
   'intereses','costomensual','productiva','idUsuario','estado'];

   public $timestamps = false;
}
