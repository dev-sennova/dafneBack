<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_usuario extends Model
{
    protected $table = 'tb_usuario';

    protected $fillable = ['nombres','apellidos','documento','direccion','telefono','email','password','estado'];

    public $timestamps = false;
}
