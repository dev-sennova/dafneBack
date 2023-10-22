<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_enlaces_legal extends Model
{
    protected $table = 'tb_enlaces_legal';

    protected $fillable = ['enlace'];

    public $timestamps = false;
}
