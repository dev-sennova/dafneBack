<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_preguntas_financiera extends Model
{
    protected $table = 'tb_preguntas_financiera';

    protected $fillable = ['pregunta'];

    public $timestamps = false;
}
