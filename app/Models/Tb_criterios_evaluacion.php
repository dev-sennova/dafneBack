<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_criterios_evaluacion extends Model
{
    protected $table = 'tb_criterios_evaluacion';

    protected $fillable = ['porcentaje','idCriterio','idIdea','idUsuario','estado'];

    public $timestamps = false;
}
