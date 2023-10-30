<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_resumen_simulacion extends Model
{
    protected $table = 'tb_resumen_simulacion';

    protected $fillable = ['idExterno','cadena','pregunta','enunciado','enlace','seccion','estado','idUsuario'];

    public $timestamps = false;
}
