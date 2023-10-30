<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_avances_financiera extends Model
{
    protected $table = 'tb_avances_financiera';

    protected $fillable = ['idExterno','cadena','pregunta','enunciado','enlace','next','estado','idUsuario'];

    public $timestamps = false;
}
