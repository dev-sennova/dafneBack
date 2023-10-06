<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_matriz_evaluacion extends Model
{
    protected $table = 'tb_matriz_evaluacion';

    protected $fillable = ['porcentaje','idUsuarioIdeas','nombreIdea','idUsuario','estado'];

    public $timestamps = false;
}
