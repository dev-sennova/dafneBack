<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Tb_relacion_ideas_criterios extends Model
{
    protected $table = 'tb_relacion_ideas_criterios';

    protected $fillable = ['porcentaje','idUsuarioIdeas','idUsuarioCriterios','idUsuario','estado'];

    public $timestamps = false;
}
