<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_ocupacion extends Model
{
    protected $table = 'tb_ocupacion';

    protected $fillable = ['ocupacion','lugar','area','idUsuario','estado'];

    public $timestamps = false;
}
