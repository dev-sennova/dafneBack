<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_proyeccion_mensual extends Model
{
    //
    protected $table = 'tb_proyeccion_mensual';

    protected $fillable = ['ingresosActividadesOrdinarias','costoVentas','utilidadBruta','gastosOperacionales','utilidadOperacional',
    'otrosIngresos','otrosEgresos','utilidadAntesImpuesto','idUsuario','estado'];

    public $timestamps = false;
}
