<?php

namespace App\Http\Controllers;

use App\Models\Tb_consolidado_simulacion_financiera;
use App\Models\Tb_financiacion;
use App\Models\Tb_gastos;
use App\Models\Tb_hoja_gastos_simula;
use Illuminate\Http\Request;

class Tb_hoja_gastos_simulaController extends Controller
{
    public function index(Request $request)
    {
        $hoja_gastos_simula = Tb_hoja_gastos_simula::orderBy('tb_hoja_gastos_simula.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'hoja_gastos_simula' => $hoja_gastos_simula
        ];
    }

    public function indexOne(Request $request)
    {
        $hoja_gastos_simula = Tb_hoja_gastos_simula::orderBy('tb_hoja_gastos_simula.id','desc')
        ->where('tb_hoja_gastos_simula.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'hoja_gastos_simula' => $hoja_gastos_simula
        ];
    }

    public function indexPropio(Request $request)
    {
        $hoja_gastos_simula = Tb_hoja_gastos_simula::orderBy('tb_hoja_gastos_simula.id','asc')
        ->where('tb_hoja_gastos_simula.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'hoja_gastos_simula' => $hoja_gastos_simula
        ];
    }

    public function consolidado(Request $request)
    {
        $hoja_gastos_simula = Tb_hoja_gastos_simula::orderBy('tb_hoja_gastos_simula.id','asc')
        ->where('tb_hoja_gastos_simula.idUsuario','=',$request->id)
        ->get();

        $consolidado=0;

        foreach($hoja_gastos_simula as $vueltaG){
                $valorP= $vueltaG->monto;

                $consolidado=$consolidado+$valorP;
        }

        return [
            'estado' => 'Ok',
            'consolidado' => $consolidado
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {

            $consolidado_simulacion_financiera = Tb_consolidado_simulacion_financiera::orderBy('tb_consolidado_simulacion_financiera.id','asc')
            ->where('tb_consolidado_simulacion_financiera.idUsuario','=',$request->idUsuario)
            ->get();

            foreach($consolidado_simulacion_financiera as $vueltaCSF){
                $idConsolidado = $vueltaCSF->id;
                }

            $cant_tb_financiacion = Tb_financiacion::where('tb_financiacion.idUsuario','=',$request->idUsuario)
            ->count();

            if($cant_tb_financiacion>0){

                $tb_financiacion = Tb_financiacion::where('tb_financiacion.idUsuario','=',$request->idUsuario)
                ->get();

                $acummulado_interes=0;

                foreach($tb_financiacion as $vueltaFin){
                    $cantidadPeriodos= $vueltaFin->cantidadPeriodos;
                    $interes= $vueltaFin->interes;
                    $acummulado_interes=$acummulado_interes+$interes;
                    }

                $interes_promedio=$acummulado_interes/$cantidadPeriodos;

                $hoja_gastos_simula=new Tb_hoja_gastos_simula();
                $hoja_gastos_simula->detalle="Intereses promedio mensuales préstamo";
                $hoja_gastos_simula->monto=$interes_promedio;
                $hoja_gastos_simula->financieros=1;
                $hoja_gastos_simula->adicionales=0;
                $hoja_gastos_simula->idUsuario=$request->idUsuario;
                $hoja_gastos_simula->estado=1;
                $hoja_gastos_simula->save();

                $tb_consolidado_simulacion_financiera=Tb_consolidado_simulacion_financiera::findOrFail($idConsolidado);
                $tb_consolidado_simulacion_financiera->valorPrestamo=$interes_promedio;
                $tb_consolidado_simulacion_financiera->save();
            }


            $tb_gastos = Tb_gastos::where('tb_gastos.idUsuario','=',$request->idUsuario)
            ->get();

            $acumulado_gastos=0;

              foreach($tb_gastos as $vueltaGastos){
                $gasto= $vueltaGastos->gasto;
                $valor= floatval($vueltaGastos->valor);

                $hoja_gastos_simula=new Tb_hoja_gastos_simula();
                $hoja_gastos_simula->detalle=$gasto;
                $hoja_gastos_simula->monto=$valor;
                $hoja_gastos_simula->financieros=0;
                $hoja_gastos_simula->adicionales=1;
                $hoja_gastos_simula->idUsuario=$request->idUsuario;
                $hoja_gastos_simula->estado=1;
                $hoja_gastos_simula->save();

                $acumulado_gastos=$acumulado_gastos+$valor;
                }

                $tb_consolidado_simulacion_financiera=Tb_consolidado_simulacion_financiera::findOrFail($idConsolidado);
                $tb_consolidado_simulacion_financiera->valorGastos=$acumulado_gastos;
                $tb_consolidado_simulacion_financiera->save();

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $hoja_gastos_simula=Tb_hoja_gastos_simula::findOrFail($request->id);
            $hoja_gastos_simula->detalle=$request->detalle;
            $hoja_gastos_simula->monto=$request->monto;
            $hoja_gastos_simula->financieros=$request->financieros;
            $hoja_gastos_simula->adicionales=$request->adicionales;
            $hoja_gastos_simula->idUsuario=$request->idUsuario;
            $hoja_gastos_simula->estado=1;

            if ($hoja_gastos_simula->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'hoja gastos actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'hoja gastos no pudo ser actualizada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

    public function deactivate(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $hoja_gastos_simula=Tb_hoja_gastos_simula::findOrFail($request->id);
            $hoja_gastos_simula->estado='0';

            if ($hoja_gastos_simula->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'hoja gastos desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'hoja gastos no pudo ser desactivada'
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
            $hoja_gastos_simula=Tb_hoja_gastos_simula::findOrFail($request->id);
            $hoja_gastos_simula->estado='1';

            if ($hoja_gastos_simula->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'hoja gastos activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'hoja gastos no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
