<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_perfiles_empresa extends Model
{
    //
    protected $table = 'tb_perfiles_empresa';

    protected $fillable = ['perfil','precio','idUsuario','estado'];

    public $timestamps = false;
}
