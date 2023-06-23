<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_ciudad extends Model
{
    protected $table = 'tb_ciudad';

    protected $fillable = ['ciudad','estado'];

    public $timestamps = false;
}
