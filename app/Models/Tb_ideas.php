<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_ideas extends Model
{
    protected $table = 'tb_ideas';

    protected $fillable = ['ideas','visibilidad','estado'];

    public $timestamps = false;
}
