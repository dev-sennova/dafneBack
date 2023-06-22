<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_usuario extends Model
{
    protected $table = 'tb_usuario';

    protected $fillable = ['nombre','tipodocumento','documento','direccion','telefono','ciudad','email','sexo','estado'];

    public $timestamps = false;
}
