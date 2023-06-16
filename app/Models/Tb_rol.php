<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_rol extends Model
{
    protected $table = 'tb_rol';

    protected $fillable = ['rol','estado'];

    public $timestamps = false;
}
