<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Tb_avances_simulacion extends Model
{
    protected $table = 'tb_avances_simulacion';

    protected $fillable = ['idExterno','cadena','pregunta','enunciado','estado','idUsuario'];

    public $timestamps = false;
}
