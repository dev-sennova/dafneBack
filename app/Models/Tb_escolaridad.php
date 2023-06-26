<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_escolaridad extends Model
{
    protected $table = 'tb_escolaridad';

    protected $fillable = ['escolaridad','nivelescolaridad','areaconocimiento','idUsuario','estado'];

    public $timestamps = false;
}
