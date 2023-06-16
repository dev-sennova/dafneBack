<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_hobbies extends Model
{
    protected $table = 'tb_hobbies';

    protected $fillable = ['hobbie','visibilidad','moderacion','estado'];

    public $timestamps = false;
}
