<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_datos_simulacion_financiera extends Model
{
    protected $table = 'tb_datos_simulacion_financiera';

    protected $fillable = ['dato'];

    public $timestamps = false;
}
