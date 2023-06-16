<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_usuario_suenos extends Model
{
    protected $table = 'tb_usuario_suenos';

    protected $fillable = ['prioridad','idUsuario','idSuenos'];

    public $timestamps = false;
}
