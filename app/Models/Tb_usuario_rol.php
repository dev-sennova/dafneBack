<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_usuario_rol extends Model
{
    protected $table = 'tb_usuario_rol';

    protected $fillable = ['idUsuario','idRol'];

    public $timestamps = false;
}
