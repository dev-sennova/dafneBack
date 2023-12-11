<?php

namespace App\Http\Controllers;

use App\Models\Tb_consolidado_simulacion_financiera;
use App\Models\Tb_estado_resultados_simula;
use App\Models\Tb_gastos_adicionales;
use App\Models\Tb_hoja_costos_simula;
use App\Models\Tb_hoja_gastos_simula;
use App\Models\Tb_ingresos_adicionales;
use App\Models\Tb_precio_venta;
use App\Models\Tb_punto_equilibrio;
use Illuminate\Http\Request;

class Tb_estado_resultados_simulaController extends Controller
{
    public function index(Request $request)
    {
        $estado_resultados_simula = Tb_estado_resultados_simula::orderBy('tb_estado_resultados_simula.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'estado_resultados_simula' => $estado_resultados_simula
        ];
    }

    public function indexOne(Request $request)
    {
        $estado_resultados_simula = Tb_estado_resultados_simula::orderBy('tb_estado_resultados_simula.id','desc')
        ->where('tb_estado_resultados_simula.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'estado_resultados_simula' => $estado_resultados_simula
        ];
    }

    public function indexPropio(Request $request)
    {
        $estado_resultados_simula = Tb_estado_resultados_simula::orderBy('tb_estado_resultados_simula.id','asc')
        ->where('tb_estado_resultados_simula.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'estado_resultados_simula' => $estado_resultados_simula
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $valorGastos=0;
            $valorIngresosAdicionales=0;
            $valorGastosAdicionales=0;
            $cantidadProducto=0;
            $talentoHumano=0;
            $costosIndirectos=0;

            //Paso 1
            $precio_venta = Tb_precio_venta::orderBy('tb_precio_venta.id','asc')
            ->where('tb_precio_venta.idUsuario','=',$request->idUsuario)
            ->get();

            foreach($precio_venta as $vueltaPV){
                $valorImpuesto = floatval($vueltaPV->valorimpuesto);
                }

            $hoja_gastos = Tb_hoja_gastos_simula::orderBy('tb_hoja_gastos_simula.id','asc')
            ->where('tb_hoja_gastos_simula.idUsuario','=',$request->idUsuario)
            ->get();

            foreach($hoja_gastos as $vueltaHG){
                $monto = floatval($vueltaHG->monto);
                $valorGastos=$valorGastos+$monto;
                }

            $ingresos_adicionales = Tb_ingresos_adicionales::orderBy('tb_ingresos_adicionales.id','asc')
            ->where('tb_ingresos_adicionales.idUsuario','=',$request->idUsuario)
            ->get();

            foreach($ingresos_adicionales as $vueltaIA){
                $valorIA = floatval($vueltaIA->valor);
                $valorIngresosAdicionales=$valorIA;
                }

            $gastos_adicionales = Tb_gastos_adicionales::orderBy('tb_gastos_adicionales.id','asc')
            ->where('tb_gastos_adicionales.idUsuario','=',$request->idUsuario)
            ->get();

            foreach($gastos_adicionales as $vueltaGA){
                $valorGA = floatval($vueltaGA->valor);
                $valorGastosAdicionales=$valorGA;
                }


            $acumulado_costos=0;
            $acumulado_productos=0;
            $tb_hoja_costos_simula_costos = Tb_hoja_costos_simula::orderBy('tb_hoja_costos_simula.id','asc')
            ->where('tb_hoja_costos_simula.idUsuario','=',$request->idUsuario)
            ->get();
            foreach($tb_hoja_costos_simula_costos as $vuelta_costos){
                $valor_costos = floatval($vuelta_costos->monto);
                $acumulado_costos=$acumulado_costos+$valor_costos;
                if($vuelta_costos->producto==1){
                    $acumulado_productos=$acumulado_productos+$valor_costos;
                }
                }

            $consolidado_simulacion_financiera = Tb_consolidado_simulacion_financiera::orderBy('tb_consolidado_simulacion_financiera.id','asc')
            ->where('tb_consolidado_simulacion_financiera.idUsuario','=',$request->idUsuario)
            ->get();

            foreach($consolidado_simulacion_financiera as $vueltaCP){
                $idConsolidado = $vueltaCP->id;
                $cantidadProducto = floatval($vueltaCP->cantidadProducto);
                $talentoHumano = floatval($vueltaCP->talentoHumano);
                $costosIndirectos = floatval($vueltaCP->costosIndirectos);
                $precioVenta = floatval($vueltaCP->precioVenta);
                }

            $valor1=$precioVenta*$cantidadProducto;
            //$porcentaje1=0;//
            $porcentaje1=($valor1/$valor1)*100;
            $valor2=$talentoHumano+$costosIndirectos;
            //$porcentaje2=0;//
            $porcentaje2=($valor2/$valor1)*100;
            $valor3=$valor1-$valor2;
            //$porcentaje3=0;//
            $porcentaje3=($valor3/$valor1)*100;
            $valor4=$valorGastos;
            //$porcentaje4=0;//
            $porcentaje4=($valor4/$valor1)*100;
            $valor5=$valor3-$valor4;
            //$porcentaje5=0;//
            $porcentaje5=($valor5/$valor1)*100;
            $valor6=$valorIngresosAdicionales;
            //$porcentaje6=0;//
            $porcentaje6=($valor6/$valor1)*100;
            $valor7=$valorGastosAdicionales;
            //$porcentaje7=0;//
            $porcentaje7=($valor7/$valor1)*100;
            $valor8=$valor5+$valor6-$valor7;
            //$porcentaje8=0;//
            $porcentaje8=($valor8/$valor1)*100;

            $detalleCalculo[] = [
                'valorImpuesto' => $valorImpuesto,
                'cantidadProducto' => $cantidadProducto,
                'talentoHumano' => $talentoHumano,
                'costosIndirectos' => $costosIndirectos,
                'valor1' => $valor1,
                'porcentaje1' => $porcentaje1,
                'valor2' => $valor2,
                'porcentaje2' => $porcentaje2,
                'valor3' => $valor3,
                'porcentaje3' => $porcentaje3,
                'valor4' => $valor4,
                'porcentaje4' => $porcentaje4,
                'valor5' => $valor5,
                'porcentaje5' => $porcentaje5,
                'valor6' => $valor6,
                'porcentaje6' => $porcentaje6,
                'valor7' => $valor7,
                'porcentaje7' => $porcentaje7,
                'valor8' => $valor8,
                'porcentaje8' => $porcentaje8
            ];

            $estado_resultados_simula1=new Tb_estado_resultados_simula();
            $estado_resultados_simula1->detalle="Ingresos por actividades ordinarias";
            $estado_resultados_simula1->valor=$valor1;
            $estado_resultados_simula1->porcentaje=$porcentaje1;
            $estado_resultados_simula1->idUsuario=$request->idUsuario;
            $estado_resultados_simula1->estado=1;
            $estado_resultados_simula1->save();

            //Paso 2
            $estado_resultados_simula2=new Tb_estado_resultados_simula();
            $estado_resultados_simula2->detalle="(-) Costo de Ventas";
            $estado_resultados_simula2->valor=$valor2;
            $estado_resultados_simula2->porcentaje=$porcentaje2;
            $estado_resultados_simula2->idUsuario=$request->idUsuario;
            $estado_resultados_simula2->estado=1;
            $estado_resultados_simula2->save();

            //Paso 3
            $estado_resultados_simula3=new Tb_estado_resultados_simula();
            $estado_resultados_simula3->detalle="(=) Margen/ Utilidad bruta";
            $estado_resultados_simula3->valor=$valor3;
            $estado_resultados_simula3->porcentaje=$porcentaje3;
            $estado_resultados_simula3->idUsuario=$request->idUsuario;
            $estado_resultados_simula3->estado=1;
            $estado_resultados_simula3->save();

            //Paso 4
            $estado_resultados_simula4=new Tb_estado_resultados_simula();
            $estado_resultados_simula4->detalle="(-) Gastos operacionales de administracion y ventas";
            $estado_resultados_simula4->valor=$valor4;
            $estado_resultados_simula4->porcentaje=$porcentaje4;
            $estado_resultados_simula4->idUsuario=$request->idUsuario;
            $estado_resultados_simula4->estado=1;
            $estado_resultados_simula4->save();

            //Paso 5
            $estado_resultados_simula5=new Tb_estado_resultados_simula();
            $estado_resultados_simula5->detalle="(=) Utilidad Operacional";
            $estado_resultados_simula5->valor=$valor5;
            $estado_resultados_simula5->porcentaje=$porcentaje5;
            $estado_resultados_simula5->idUsuario=$request->idUsuario;
            $estado_resultados_simula5->estado=1;
            $estado_resultados_simula5->save();

            //Paso 6
            $estado_resultados_simula6=new Tb_estado_resultados_simula();
            $estado_resultados_simula6->detalle="(+) Otros Ingresos";
            $estado_resultados_simula6->valor=$valor6;
            $estado_resultados_simula6->porcentaje=$porcentaje6;
            $estado_resultados_simula6->idUsuario=$request->idUsuario;
            $estado_resultados_simula6->estado=1;
            $estado_resultados_simula6->save();

            //Paso 7
            $estado_resultados_simula7=new Tb_estado_resultados_simula();
            $estado_resultados_simula7->detalle="(-) Otros Egresos";
            $estado_resultados_simula7->valor=$valor7;
            $estado_resultados_simula7->porcentaje=$porcentaje7;
            $estado_resultados_simula7->idUsuario=$request->idUsuario;
            $estado_resultados_simula7->estado=1;
            $estado_resultados_simula7->save();

            //Paso 8
            $estado_resultados_simula8=new Tb_estado_resultados_simula();
            $estado_resultados_simula8->detalle="(=) Utilidad antes de Impuesto";
            $estado_resultados_simula8->valor=$valor8;
            $estado_resultados_simula8->porcentaje=$porcentaje8;
            $estado_resultados_simula8->idUsuario=$request->idUsuario;
            $estado_resultados_simula8->estado=1;
            $estado_resultados_simula8->save();

            $base=0;
            $div=0;
            $punto_equilibrio=0;
            $punto=0;

            $base=$valor2+$valor4;
            $div=$precioVenta-$acumulado_productos;
            $punto_equilibrio=$base/$div;

            $punto=ceil($punto_equilibrio);

            $tb_punto_equilibrio=new Tb_punto_equilibrio();
            $tb_punto_equilibrio->costosGastos=floatval($base);
            $tb_punto_equilibrio->precioVentaSinIva=floatval($precioVenta);
            $tb_punto_equilibrio->productosInsumos=floatval($acumulado_productos);
            $tb_punto_equilibrio->idUsuario=$request->idUsuario;
            $tb_punto_equilibrio->estado=1;
            $tb_punto_equilibrio->save();

            $tb_consolidado_simulacion_financieraFIN=Tb_consolidado_simulacion_financiera::findOrFail($idConsolidado);
            $tb_consolidado_simulacion_financieraFIN->ingresosOrdinarios=$valor1;
            $tb_consolidado_simulacion_financieraFIN->costoVentas=$valor2;
            $tb_consolidado_simulacion_financieraFIN->utilidadBruta=$valor3;
            $tb_consolidado_simulacion_financieraFIN->gastosOperacionales=$valor4;
            $tb_consolidado_simulacion_financieraFIN->utilidadOperacional=$valor5;
            $tb_consolidado_simulacion_financieraFIN->ingresosAdicionales=$valor6;
            $tb_consolidado_simulacion_financieraFIN->egresosAdicionales=$valor7;
            $tb_consolidado_simulacion_financieraFIN->utilidadPreImpuesto=$valor8;
            $tb_consolidado_simulacion_financieraFIN->puntoEquilibrio=$punto;
            $tb_consolidado_simulacion_financieraFIN->save();

            /*
            $tb_consolidado_simulacion_financieraFIN=Tb_consolidado_simulacion_financiera::findOrFail($idConsolidado);
            $tb_consolidado_simulacion_financieraFIN->ingresosOrdinarios=$valor1;
            $tb_consolidado_simulacion_financieraFIN->costoVentas=number_format($valor2, 2);
            $tb_consolidado_simulacion_financieraFIN->utilidadBruta=number_format($valor3, 2);
            $tb_consolidado_simulacion_financieraFIN->gastosOperacionales=$valor4;
            $tb_consolidado_simulacion_financieraFIN->utilidadOperacional=number_format($valor5, 2);
            $tb_consolidado_simulacion_financieraFIN->ingresosAdicionales=$valor6;
            $tb_consolidado_simulacion_financieraFIN->egresosAdicionales=$valor7;
            $tb_consolidado_simulacion_financieraFIN->utilidadPreImpuesto=number_format($valor8, 2);
            $tb_consolidado_simulacion_financieraFIN->puntoEquilibrio=$punto;
            $tb_consolidado_simulacion_financieraFIN->save();
            */

            return response()->json([
                'estado' => 'Ok',
                'message' => 'estados resultados creada con éxito',
                'detalleCalculo' => $detalleCalculo
               ]);

         } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocurrió un error interno resultados: '+$detalleCalculo], 500);
        }

    }

    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $estado_resultados_simula=Tb_estado_resultados_simula::findOrFail($request->id);
            $estado_resultados_simula->detalle=$request->detalle;
            $estado_resultados_simula->valor=$request->valor;
            $estado_resultados_simula->porcentaje=$request->porcentaje;
            $estado_resultados_simula->idUsuario=$request->idUsuario;
            $estado_resultados_simula->estado=1;

            if ($estado_resultados_simula->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'estados resultados actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'estados resultados no pudo ser actualizada'
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
            $estado_resultados_simula=Tb_estado_resultados_simula::findOrFail($request->id);
            $estado_resultados_simula->estado='0';

            if ($estado_resultados_simula->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'estados resultados desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'estados resultados no pudo ser desactivada'
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
            $estado_resultados_simula=Tb_estado_resultados_simula::findOrFail($request->id);
            $estado_resultados_simula->estado='1';

            if ($estado_resultados_simula->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'estados resultados activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'estados resultados no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
