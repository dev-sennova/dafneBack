<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_enunciados extends Model
{
    protected $table = 'tb_enunciados';

    protected $fillable = ['enunciado'];

    public $timestamps = false;
}
