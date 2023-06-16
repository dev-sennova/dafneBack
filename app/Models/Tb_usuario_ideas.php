<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_usuario_ideas extends Model
{
    protected $table = 'tb_usuario_ideas';

    protected $fillable = ['idUsuario','idideas'];

    public $timestamps = false;
}
