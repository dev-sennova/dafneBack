<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_experiencia extends Model
{
    protected $table = 'tb_experiencia';

    protected $fillable = ['experiencia','actividades','area','idUsuario','estado'];

    public $timestamps = false;
}
