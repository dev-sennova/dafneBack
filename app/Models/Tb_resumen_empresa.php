<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Tb_resumen_empresa extends Model
{
    protected $table = 'tb_resumen_empresa';

    protected $fillable = ['nombreIdea','idUsuario','nombreEmpresa','mision','vision','slogan','logo','estado'];

    public $timestamps = false;
}
