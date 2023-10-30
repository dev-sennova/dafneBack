<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_calculos_financiera extends Model
{
    protected $table = 'tb_calculos_financiera';

    protected $fillable = ['calculo'];

    public $timestamps = false;
}
