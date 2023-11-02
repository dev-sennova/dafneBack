<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_variables_globales extends Model
{
    protected $table = 'tb_variables_globales';

    protected $fillable = ['variable','valor','estado'];

    public $timestamps = false;
}
