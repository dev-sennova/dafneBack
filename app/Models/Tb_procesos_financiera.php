<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_procesos_financiera extends Model
{
    protected $table = 'tb_procesos_financiera';

    protected $fillable = ['proceso'];

    public $timestamps = false;
}
