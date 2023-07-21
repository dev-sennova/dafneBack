<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_usuario_criterios extends Model
{
    protected $table = 'tb_usuario_criterios';

    protected $fillable = ['porcentaje','idUsuario','idCriterio','estado'];

    public $timestamps = false;
}
