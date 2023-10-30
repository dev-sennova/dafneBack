<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_enunciados_financiera extends Model
{
    protected $table = 'tb_enunciados_financiera';

    protected $fillable = ['enunciado'];

    public $timestamps = false;
}
