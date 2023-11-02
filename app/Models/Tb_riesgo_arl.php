<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_riesgo_arl extends Model
{
    protected $table = 'tb_riesgo_arl';

    protected $fillable = ['riesgo','porcentaje','estado'];

    public $timestamps = false;
}
