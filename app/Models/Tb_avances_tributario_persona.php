<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_avances_tributario_persona extends Model
{
    protected $table = 'tb_avances_tributario_persona';

    protected $fillable = ['idExterno','cadena','pregunta','enunciado','enlace','estado','idUsuario'];

    public $timestamps = false;
}
