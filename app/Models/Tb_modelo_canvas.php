<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_modelo_canvas extends Model
{
    protected $table = 'tb_modelo_canvas';

    protected $fillable = ['proposicion','segmento','relaciones','canales','actividades','recursos','aliados','flujos','estructura','avancepro','avanceseg','avancerel','avancecan','avanceact','avancerec','avanceali','avanceflu','avanceest','estado','idUsuario'];

    public $timestamps = false;
}
