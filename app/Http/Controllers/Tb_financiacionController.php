<?php

namespace App\Http\Controllers;

use App\Models\Tb_consolidado_simulacion_financiera;
use App\Models\Tb_financiacion;
use Illuminate\Http\Request;

class Tb_financiacionController extends Controller
{
    public function index(Request $request)
    {
        $financiacion = Tb_financiacion::orderBy('tb_financiacion.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'financiacion' => $financiacion
        ];
    }

    public function indexOne(Request $request)
    {
        $financiacion = Tb_financiacion::orderBy('tb_financiacion.id','desc')
        ->where('tb_financiacion.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'financiacion' => $financiacion
        ];
    }

    public function indexPropio(Request $request)
    {
        $financiacion = Tb_financiacion::orderBy('tb_financiacion.id','asc')
        ->where('tb_financiacion.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'financiacion' => $financiacion
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $varcantPeriodos=floatval($request->cantidadPeriodos); //30
            $varValor=floatval($request->valor); //20000000
            $varTasaAnualP=floatval($request->tasaAnual);      // 32 - 0
            $varTasaMensualP=floatval($request->tasaMensual); //   0 - 2.34
            $varTasaAnual=$varTasaAnualP/100;                 // 0.32 - 0
            $varTasaMensual=$varTasaMensualP/100;             // 0 - 0.0234

            if($request->anual==1){//calcular tasas si pasan anual
                $a=round((1+$varTasaAnual), 4); // 32 --> 0.32 --> 1.32
                $b=round(($varcantPeriodos/360), 4); // 30 --> 0.0833
                $c=round((pow($a, $b)), 4); // 1.0234
                $d=$c-1; // 0.0234
                $tasaAnual=$varTasaAnual; // 0.32
                $tasaMensual=round(($d*100), 2); // 0.0234*100 --> 2.34
                $valtasaAnual=$varTasaAnualP; // 32
                $valtasaMensual=$tasaMensual; // 2.34
            }else{
                $a=round((1+$varTasaMensual), 4); // 0.0234 --> 1.0234
                $b=round((1/($varcantPeriodos/360)), 4); // 12
                $c=round((pow($a, $b)), 4); // 1.32
                $d=$c-1; // 0.32
                $tasaAnual=$d; // 0.32
                $tasaMensual=$varTasaMensualP; // 2.34
                $valtasaAnual=round(($tasaAnual*100), 2); // 32
                $valtasaMensual=$tasaMensual; // 2.34
            }

            $tasaconvertida=$tasaMensual*0.01; // 0.0234 - 0.0234
            $valI=1+$tasaconvertida; // 1.0234 - 1.0234
            $valG=pow($valI, $varcantPeriodos); // 2.00153 - 2.00153
            $valNum=($valG*$tasaconvertida); // 0.0468 - 0.0468
            $valDen=$valG-1; // 1.00153 - 1.00153
            $cuotaP=$varValor*($valNum/$valDen); // 934570 -
            $cuota=round($cuotaP,2);

            $valorP=$varValor;

            for($i=1; $i<=$request->cantidadPeriodos; $i++){
                $interes=round(($valorP*$tasaconvertida),2);
                $amortizacion=round(($cuota-$interes),2);
                $saldo=round(($valorP-$amortizacion),2);

                $detalleFinanciacion[] = [
                    'tasaconvertida' => $tasaconvertida,
                    'valI' => $valI,
                    'valG' => $valG,
                    'valNum' => $valNum,
                    'valDen' => $valDen,
                    'cuotaP' => $cuotaP,
                    'cuota' => $cuota,
                    'tasaAnual' => $valtasaAnual,
                    'tasaMensual' => $valtasaMensual,
                    'cantPeriodos' => $varcantPeriodos,
                    'periodo' => $i,
                    'cuota' => $cuota,
                    'capitalInicial' => $valorP,
                    'interes' => $interes,
                    'amortizacion' => $amortizacion,
                    'saldo' => $saldo,
                ];

                $tb_financiacion=new Tb_financiacion();
                $tb_financiacion->valor=$request->valor;
                $tb_financiacion->anual=$request->anual;
                $tb_financiacion->tasaAnual=$valtasaAnual;
                $tb_financiacion->tasaMensual=$valtasaMensual;
                $tb_financiacion->cantidadPeriodos=$request->cantidadPeriodos;
                $tb_financiacion->cuota=$cuota;
                $tb_financiacion->periodo=$i;
                $tb_financiacion->capitalInicial=$valorP;
                $tb_financiacion->interes=$interes;
                $tb_financiacion->amortizacion=$amortizacion;
                $tb_financiacion->saldo=$saldo;
                $tb_financiacion->idUsuario=$request->idUsuario;
                $tb_financiacion->estado=1;
                $tb_financiacion->save();

                $valorP=$saldo;
            }

            $consolidado_simulacion_financiera = Tb_consolidado_simulacion_financiera::orderBy('tb_consolidado_simulacion_financiera.id','asc')
            ->where('tb_consolidado_simulacion_financiera.idUsuario','=',$request->idUsuario)
            ->get();

            foreach($consolidado_simulacion_financiera as $vueltaCSF){
                $idConsolidado = $vueltaCSF->id;
                }

                $tb_consolidado_simulacion_financiera=Tb_consolidado_simulacion_financiera::findOrFail($idConsolidado);
                $tb_consolidado_simulacion_financiera->valorPrestamo=$cuota;
                $tb_consolidado_simulacion_financiera->save();

            return response()->json([
                'estado' => 'Ok',
                'message' => 'financiacion creada con éxito',
                'detalleFinanciacion' => $detalleFinanciacion
                ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno: '.$e], 500);
        }

    }

    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_financiacion=Tb_financiacion::findOrFail($request->id);
            $tb_financiacion->valor=$request->valor;
            $tb_financiacion->anual=$request->anual;
            $tb_financiacion->tasaAnual=$request->tasaAnual;
            $tb_financiacion->tasaMensual=$request->tasaMensual;
            $tb_financiacion->cantidadPeriodos=$request->cantidadPeriodos;
            $tb_financiacion->cuota=$request->cuota;
            $tb_financiacion->periodo=$request->periodo;
            $tb_financiacion->capitalInicial=$request->tasaAnual;
            $tb_financiacion->interes=$request->interes;
            $tb_financiacion->amortizacion=$request->amortizacion;
            $tb_financiacion->saldo=$request->saldo;
            $tb_financiacion->idUsuario=$request->idUsuario;
            $tb_financiacion->estado=1;

            if ($tb_financiacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'financiacion actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'financiacion no pudo ser actualizada'
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
            $tb_financiacion=Tb_financiacion::findOrFail($request->id);
            $tb_financiacion->estado='0';

            if ($tb_financiacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'financiacion desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'financiacion no pudo ser desactivada'
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
            $tb_financiacion=Tb_financiacion::findOrFail($request->id);
            $tb_financiacion->estado='1';

            if ($tb_financiacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'financiacion activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'financiacion no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
