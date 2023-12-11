<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_impuesto extends Model
{
    protected $table = 'tb_impuesto';

    protected $fillable = ['impuesto','porcentaje','estado'];

    public $timestamps = false;
}
