<?php

namespace App\Http\Controllers;

use App\Models\Tb_datos_simulacion_financiera;
use Illuminate\Http\Request;

class Tb_datos_simulacion_financieraController extends Controller
{
    public function index(Request $request)
    {
        $datos = Tb_datos_simulacion_financiera::orderBy('datos','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'datos' => $datos
        ];
    }

    public function indexOne(Request $request)
    {
        $datos = Tb_datos_simulacion_financiera::orderBy('datos','desc')
        ->where('tb_datos_simulacion_financiera.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'datos' => $datos
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_datos_simulacion_financiera=new Tb_datos_simulacion_financiera();
            $tb_datos_simulacion_financiera->dato=$request->dato;
            $tb_datos_simulacion_financiera->estado=1;

            if ($tb_datos_simulacion_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'datos creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'datos no pudo ser creada'
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
            $tb_datos_simulacion_financiera=Tb_datos_simulacion_financiera::findOrFail($request->id);
            $tb_datos_simulacion_financiera->dato=$request->dato;
            $tb_datos_simulacion_financiera->estado='1';

            if ($tb_datos_simulacion_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'datos actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'datos no pudo ser actualizada'
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
            $tb_datos_simulacion_financiera=Tb_datos_simulacion_financiera::findOrFail($request->id);
            $tb_datos_simulacion_financiera->estado='0';

            if ($tb_datos_simulacion_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'datos desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'datos no pudo ser desactivada'
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
            $tb_datos_simulacion_financiera=Tb_datos_simulacion_financiera::findOrFail($request->id);
            $tb_datos_simulacion_financiera->estado='1';

            if ($tb_datos_simulacion_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'datos activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'datos no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
