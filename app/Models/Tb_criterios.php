<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_criterios extends Model
{
    protected $table = 'tb_criterios';

    protected $fillable = ['criterio','pregunta','visibilidad','moderacion','estado'];

    public $timestamps = false;
}
