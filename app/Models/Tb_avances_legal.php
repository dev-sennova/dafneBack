<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_avances_legal extends Model
{
    protected $table = 'tb_avances_legal';

    protected $fillable = ['idExterno','cadena','pregunta','enunciado','enlace','estado','idUsuario'];

    public $timestamps = false;
}
