<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_directorio extends Model
{
    protected $table = 'tb_directorio';

    protected $fillable = ['entidad','municipio','direccion','web','telefonos','chat','correo','tipo','estado'];

    public $timestamps = false;
}
