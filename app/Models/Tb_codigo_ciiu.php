<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_codigo_ciiu extends Model
{
    protected $table = 'tb_codigo_ciiu';

    protected $fillable = ['descripcion','codigo','idriesgo','estado'];

    public $timestamps = false;
}
