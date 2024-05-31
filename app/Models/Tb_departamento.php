<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Tb_departamento extends Model
{
    protected $table = 'tb_departamentos';

    protected $fillable = ['nombre','estado'];

    public $timestamps = false;

    public function ciudades()
    {
        return $this->hasMany(Tb_Ciudad::class);
    }
}
