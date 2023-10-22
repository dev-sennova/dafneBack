<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_preguntas_tributario extends Model
{
    protected $table = 'tb_preguntas_tributario';

    protected $fillable = ['pregunta'];

    public $timestamps = false;
}
