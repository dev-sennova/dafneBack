<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_ingresos_adicionales extends Model
{
     //
     protected $table = 'tb_ingresos_adicionales';

     protected $fillable = ['concepto','valor','idUsuario','estado'];

     public $timestamps = false;
}
