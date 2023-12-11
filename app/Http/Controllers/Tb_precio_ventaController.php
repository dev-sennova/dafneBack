<?php

namespace App\Http\Controllers;

use App\Models\Tb_consolidado_simulacion_financiera;
use App\Models\Tb_precio_venta;
use Illuminate\Http\Request;

class Tb_precio_ventaController extends Controller
{
    public function index(Request $request)
    {
        $precio_venta = Tb_precio_venta::orderBy('tb_precio_venta.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'precio_venta' => $precio_venta
        ];
    }

    public function indexOne(Request $request)
    {
        $precio_venta = Tb_precio_venta::orderBy('tb_precio_venta.id','desc')
        ->where('tb_precio_venta.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'precio_venta' => $precio_venta
        ];
    }

    public function indexPropio(Request $request)
    {
        $precio_venta = Tb_precio_venta::orderBy('tb_precio_venta.id','asc')
        ->where('tb_precio_venta.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'precio_venta' => $precio_venta
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

            $impuesto=0;
            $costoP=floatval($request->costo);
            $margenP=floatval($request->margen);
            $baseimpuesto=floatval($request->impuesto);
            $denom=$margenP/100;
            $porcentajeimpuesto=$baseimpuesto/100;
            $denomP=1-$denom;
            $margenCalc=round($denomP,2);
            $precioP=round(($costoP/$margenCalc), 2);
            $valorimpuesto=$precioP*$porcentajeimpuesto;
            $impuesto=round($valorimpuesto,2);
            $precioF=$precioP+$impuesto;

            $detalleCalculo[] = [
                'costoP' => $costoP,
                'margenP' => $margenP,
                'denom' => $denom,
                'margenCalc' => $margenCalc,
                'precioP' => $precioP,
                'impuesto' => $impuesto,
                'venta' => $precioP
            ];

            $tb_precio_venta=new Tb_precio_venta();
            $tb_precio_venta->costo=$request->costo;
            $tb_precio_venta->margen=$request->margen;
            $tb_precio_venta->venta=$precioP;
            $tb_precio_venta->impuesto=$impuesto;
            $tb_precio_venta->valorimpuesto=$precioF;
            $tb_precio_venta->idUsuario=$request->idUsuario;
            $tb_precio_venta->estado=1;


            if ($tb_precio_venta->save()) {

                $tb_consolidado_simulacion_financiera=Tb_consolidado_simulacion_financiera::findOrFail($idConsolidado);
                $tb_consolidado_simulacion_financiera->margenGanancia=$request->margen;
                $tb_consolidado_simulacion_financiera->precioVenta=$precioP;
                $tb_consolidado_simulacion_financiera->precioIva=$precioF;
                $tb_consolidado_simulacion_financiera->save();

                    return response()->json([
                        'estado' => 'Ok',
                        'message' => 'Precio venta creado',
                        'detalleCalculo' => $detalleCalculo
                    ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'precio_venta no pudo ser creada',
                    'detalleCalculo' => $detalleCalculo
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno: '.$e], 500);
        }

    }

    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_precio_venta=Tb_precio_venta::findOrFail($request->id);
            $tb_precio_venta->costo=$request->costo;
            $tb_precio_venta->margen=$request->margen;
            $tb_precio_venta->venta=$request->venta;
            $tb_precio_venta->impuesto=$request->impuesto;
            $tb_precio_venta->valorimpuesto=$request->valorimpuesto;
            $tb_precio_venta->idUsuario=$request->idUsuario;
            $tb_precio_venta->estado=1;

            if ($tb_precio_venta->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'precio_venta actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'precio_venta no pudo ser actualizada'
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
            $tb_precio_venta=Tb_precio_venta::findOrFail($request->id);
            $tb_precio_venta->estado='0';

            if ($tb_precio_venta->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'precio_venta desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'precio_venta no pudo ser desactivada'
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
            $tb_precio_venta=Tb_precio_venta::findOrFail($request->id);
            $tb_precio_venta->estado='1';

            if ($tb_precio_venta->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'precio_venta activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'precio_venta no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
