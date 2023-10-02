<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Tb_modulo extends Model
{
    protected $table = 'tb_modulo';

    protected $fillable = ['modulo'];

    public $timestamps = false;
}
