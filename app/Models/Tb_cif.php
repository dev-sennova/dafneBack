<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_cif extends Model
{
    //
    protected $table = 'tb_cif';

    protected $fillable = ['cif','valor','idUsuario','estado'];

    public $timestamps = false;
}
