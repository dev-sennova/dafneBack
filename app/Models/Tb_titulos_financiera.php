<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_titulos_financiera extends Model
{
    protected $table = 'tb_titulos_financiera';

    protected $fillable = ['titulo'];

    public $timestamps = false;
}
