<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_salidas_financiera extends Model
{
    protected $table = 'tb_salidas_financiera';

    protected $fillable = ['salida'];

    public $timestamps = false;
}
