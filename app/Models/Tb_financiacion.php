<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_financiacion extends Model
{
    //
    protected $table = 'tb_financiacion';

    protected $fillable = ['valor','anual','tasaAnual','tasaMensual','cantidadPeriodos','cuota','periodo','capitalInicial','interes',
    'amortizacion','saldo','idUsuario','estado'];

    public $timestamps = false;
}
