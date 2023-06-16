<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_criterios_evaluacion extends Model
{
    protected $table = 'tb_criterios_evaluacion';

    protected $fillable = ['ideas','visibilidad','idideas','estado'];

    public $timestamps = false;
}
