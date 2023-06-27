<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_usuario_hobbies extends Model
{
    protected $table = 'tb_usuario_hobbies';

    protected $fillable = ['idUsuario','idHobby','estado'];

    public $timestamps = false;

}
