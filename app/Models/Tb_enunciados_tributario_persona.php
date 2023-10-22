<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_enunciados_tributario_persona extends Model
{
    protected $table = 'tb_enunciados_tributario_persona';

    protected $fillable = ['enunciado'];

    public $timestamps = false;
}
