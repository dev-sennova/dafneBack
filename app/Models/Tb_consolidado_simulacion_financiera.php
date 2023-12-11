<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_consolidado_simulacion_financiera extends Model
{
    //
    protected $table = 'tb_consolidado_simulacion_financiera';

    protected $fillable = ['producto','nombreProducto','descripcionProducto','nombreEmpresa','cantidadProducto','costoMateriales','costoCompra','personaNatural','codigoCiiu','nivelRiesgo','costosIndirectos','talentoHumano','valorPrestamo','valorGastos',
    'margenGanancia','precioVenta','precioIva','puntoEquilibrio','ingresosAdicionales','ingresosOrdinarios','costoVentas','utilidadBruta','gastosOperacionales','utilidadOperacional','egresosAdicionales','utilidadPreImpuesto','pasosAvance','idUsuario'];

    public $timestamps = false;
}
