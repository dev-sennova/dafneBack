<?php

namespace App\Http\Controllers;

use App\Models\Tb_consolidado_simulacion_financiera;
use Illuminate\Http\Request;

class Tb_consolidado_simulacion_financieraController extends Controller
{
    public function index(Request $request)
    {
        $consolidado_simulacion_financiera = Tb_consolidado_simulacion_financiera::orderBy('tb_consolidado_simulacion_financiera.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'consolidado_simulacion_financiera' => $consolidado_simulacion_financiera
        ];
    }

    public function indexOne(Request $request)
    {
        $consolidado_simulacion_financiera = Tb_consolidado_simulacion_financiera::orderBy('tb_consolidado_simulacion_financiera.id','desc')
        ->where('tb_consolidado_simulacion_financiera.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'consolidado_simulacion_financiera' => $consolidado_simulacion_financiera
        ];
    }

    public function indexPropio(Request $request)
    {
        $consolidado_simulacion_financiera = Tb_consolidado_simulacion_financiera::orderBy('tb_consolidado_simulacion_financiera.id','asc')
        ->where('tb_consolidado_simulacion_financiera.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'consolidado_simulacion_financiera' => $consolidado_simulacion_financiera
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_consolidado_simulacion_financiera=new Tb_consolidado_simulacion_financiera();
            $tb_consolidado_simulacion_financiera->producto=$request->producto;
            $tb_consolidado_simulacion_financiera->nombreProducto=$request->nombreProducto;
            $tb_consolidado_simulacion_financiera->descripcionProducto=$request->descripcionProducto;
            $tb_consolidado_simulacion_financiera->nombreEmpresa=$request->nombreEmpresa;
            $tb_consolidado_simulacion_financiera->cantidadProducto=$request->cantidadProducto;
            $tb_consolidado_simulacion_financiera->costoMateriales=$request->costoMateriales;
            $tb_consolidado_simulacion_financiera->costoCompra=$request->costoCompra;
            $tb_consolidado_simulacion_financiera->personaNatural=$request->personaNatural;
            $tb_consolidado_simulacion_financiera->codigoCiiu=$request->codigoCiiu;
            $tb_consolidado_simulacion_financiera->nivelRiesgo=$request->nivelRiesgo;
            $tb_consolidado_simulacion_financiera->costosIndirectos=$request->costosIndirectos;
            $tb_consolidado_simulacion_financiera->talentoHumano=$request->talentoHumano;
            $tb_consolidado_simulacion_financiera->valorPrestamo=$request->valorPrestamo;
            $tb_consolidado_simulacion_financiera->valorGastos=$request->valorGastos;
            $tb_consolidado_simulacion_financiera->margenGanancia=$request->margenGanancia;
            $tb_consolidado_simulacion_financiera->precioVenta=$request->precioVenta;
            $tb_consolidado_simulacion_financiera->precioIva=$request->precioIva;
            $tb_consolidado_simulacion_financiera->puntoEquilibrio=$request->puntoEquilibrio;
            $tb_consolidado_simulacion_financiera->ingresosAdicionales=$request->ingresosAdicionales;
            $tb_consolidado_simulacion_financiera->ingresosOrdinarios=$request->ingresosOrdinarios;
            $tb_consolidado_simulacion_financiera->costoVentas=$request->costoVentas;
            $tb_consolidado_simulacion_financiera->utilidadBruta=$request->utilidadBruta;
            $tb_consolidado_simulacion_financiera->gastosOperacionales=$request->gastosOperacionales;
            $tb_consolidado_simulacion_financiera->utilidadOperacional=$request->utilidadOperacional;
            $tb_consolidado_simulacion_financiera->egresosAdicionales=$request->egresosAdicionales;
            $tb_consolidado_simulacion_financiera->utilidadPreImpuesto=$request->utilidadPreImpuesto;
            $tb_consolidado_simulacion_financiera->idUsuario=$request->idUsuario;

            if ($tb_consolidado_simulacion_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'consolidado simulacion financiera creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'consolidado simulacion financiera no pudo ser creada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno: '.$e], 500);
        }

    }

    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $consolidado_simulacion_financiera = Tb_consolidado_simulacion_financiera::orderBy('tb_consolidado_simulacion_financiera.id','asc')
        ->where('tb_consolidado_simulacion_financiera.idUsuario','=',$request->idUsuario)
        ->get();

        foreach($consolidado_simulacion_financiera as $vueltaP){
            $idConsolidado = $vueltaP->id;
            }

        try {
            $tb_consolidado_simulacion_financiera=Tb_consolidado_simulacion_financiera::findOrFail($idConsolidado);
            $tb_consolidado_simulacion_financiera->producto=$request->producto;
            $tb_consolidado_simulacion_financiera->nombreProducto=$request->nombreProducto;
            $tb_consolidado_simulacion_financiera->descripcionProducto=$request->descripcionProducto;
            $tb_consolidado_simulacion_financiera->nombreEmpresa=$request->nombreEmpresa;
            $tb_consolidado_simulacion_financiera->cantidadProducto=$request->cantidadProducto;
            $tb_consolidado_simulacion_financiera->costoMateriales=$request->costoMateriales;
            $tb_consolidado_simulacion_financiera->costoCompra=$request->costoCompra;
            $tb_consolidado_simulacion_financiera->personaNatural=$request->personaNatural;
            $tb_consolidado_simulacion_financiera->codigoCiiu=$request->codigoCiiu;
            $tb_consolidado_simulacion_financiera->nivelRiesgo=$request->nivelRiesgo;
            $tb_consolidado_simulacion_financiera->margenGanancia=$request->margenGanancia;
            $tb_consolidado_simulacion_financiera->precioVenta=$request->precioVenta;
            $tb_consolidado_simulacion_financiera->precioIva=$request->precioIva;
            $tb_consolidado_simulacion_financiera->pasosAvance=$request->pasosAvance;
            $tb_consolidado_simulacion_financiera->idUsuario=$request->idUsuario;


            if ($tb_consolidado_simulacion_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'consolidado simulacion financiera actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error: ',
                    'message' => 'consolidado simulacion financiera no pudo ser actualizada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno: '.$e], 500);
        }

    }

    public function deactivate(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_consolidado_simulacion_financiera=Tb_consolidado_simulacion_financiera::findOrFail($request->id);
            $tb_consolidado_simulacion_financiera->estado='0';

            if ($tb_consolidado_simulacion_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'consolidado simulacion financiera desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'consolidado simulacion financiera no pudo ser desactivada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

    public function activate(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_consolidado_simulacion_financiera=Tb_consolidado_simulacion_financiera::findOrFail($request->id);
            $tb_consolidado_simulacion_financiera->estado='1';

            if ($tb_consolidado_simulacion_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'consolidado simulacion financiera activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'consolidado simulacion financiera no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

    public function resetFinanciera(Request $request)
    {
        if($tb_consolidado_simulacion_financiera=Tb_consolidado_simulacion_financiera::where('tb_consolidado_simulacion_financiera.idUsuario',$request->idUsuario)->delete()){
            return [
                'estado' => 'Ok',
                'reset_simulacion_financiera' => "Módulo reseteado con éxito"
            ];
        }else{
            return [
                'estado' => 'Error',
                'reset_simulacion_financiera' => "Falló el reseteo del módulo"
            ];
        }
    }
}
