<?php

namespace App\Http\Controllers;

use App\Models\Tb_proyeccion_mensual;
use Illuminate\Http\Request;

class Tb_proyeccion_mensualController extends Controller
{
    public function index(Request $request)
    {
        $proyeccion_mensual = Tb_proyeccion_mensual::orderBy('tb_proyeccion_mensual.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'proyeccion_mensual' => $proyeccion_mensual
        ];
    }

    public function indexOne(Request $request)
    {
        $proyeccion_mensual = Tb_proyeccion_mensual::orderBy('tb_proyeccion_mensual.id','desc')
        ->where('tb_proyeccion_mensual.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'proyeccion_mensual' => $proyeccion_mensual
        ];
    }

    public function indexPropio(Request $request)
    {
        $proyeccion_mensual = Tb_proyeccion_mensual::orderBy('tb_proyeccion_mensual.id','asc')
        ->where('tb_proyeccion_mensual.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'proyeccion_mensual' => $proyeccion_mensual
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_proyeccion_mensual=new Tb_proyeccion_mensual();
            $tb_proyeccion_mensual->ingresosActividadesOrdinarias=$request->ingresosActividadesOrdinarias;
            $tb_proyeccion_mensual->costoVentas=$request->costoVentas;
            $tb_proyeccion_mensual->utilidadBruta=$request->utilidadBruta;
            $tb_proyeccion_mensual->gastosOperacionales=$request->gastosOperacionales;
            $tb_proyeccion_mensual->utilidadOperacional=$request->utilidadOperacional;
            $tb_proyeccion_mensual->otrosIngresos=$request->otrosIngresos;
            $tb_proyeccion_mensual->otrosEgresos=$request->otrosEgresos;
            $tb_proyeccion_mensual->utilidadAntesImpuesto=$request->utilidadAntesImpuesto;
            $tb_proyeccion_mensual->idUsuario=$request->idUsuario;
            $tb_proyeccion_mensual->estado=1;

            if ($tb_proyeccion_mensual->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'proyeccion_mensual creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'proyeccion_mensual no pudo ser creada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_proyeccion_mensual=Tb_proyeccion_mensual::findOrFail($request->id);
            $tb_proyeccion_mensual->ingresosActividadesOrdinarias=$request->ingresosActividadesOrdinarias;
            $tb_proyeccion_mensual->costoVentas=$request->costoVentas;
            $tb_proyeccion_mensual->utilidadBruta=$request->utilidadBruta;
            $tb_proyeccion_mensual->gastosOperacionales=$request->gastosOperacionales;
            $tb_proyeccion_mensual->utilidadOperacional=$request->utilidadOperacional;
            $tb_proyeccion_mensual->otrosIngresos=$request->otrosIngresos;
            $tb_proyeccion_mensual->otrosEgresos=$request->otrosEgresos;
            $tb_proyeccion_mensual->utilidadAntesImpuesto=$request->utilidadAntesImpuesto;
            $tb_proyeccion_mensual->idUsuario=$request->idUsuario;
            $tb_proyeccion_mensual->estado=1;

            if ($tb_proyeccion_mensual->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'proyeccion_mensual actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'proyeccion_mensual no pudo ser actualizada'
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
            $tb_proyeccion_mensual=Tb_proyeccion_mensual::findOrFail($request->id);
            $tb_proyeccion_mensual->estado='0';

            if ($tb_proyeccion_mensual->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'proyeccion_mensual desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'proyeccion_mensual no pudo ser desactivada'
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
            $tb_proyeccion_mensual=Tb_proyeccion_mensual::findOrFail($request->id);
            $tb_proyeccion_mensual->estado='1';

            if ($tb_proyeccion_mensual->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'proyeccion_mensual activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'proyeccion_mensual no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
