<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Tb_preguntas_caracterizacion extends Model
{
    protected $table = 'tb_preguntas_caracterizacion';

    protected $fillable = ['pregunta'];

    public $timestamps = false;
}
