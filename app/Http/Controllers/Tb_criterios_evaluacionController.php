<?php

namespace App\Http\Controllers;

use App\Models\Tb_criterios_evaluacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_criterios_evaluacionController extends Controller
{
    public function index(Request $request)
    {
        $criterios_evaluacion = Tb_criterios_evaluacion::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'criterios_evaluacion' => $criterios_evaluacion
        ];
    }

    public function indexOne(Request $request)
    {
        $criterios_evaluacion = Tb_criterios_evaluacion::orderBy('id','desc')
        ->where('tb_criterios_evaluacion.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'criterios_evaluacion' => $criterios_evaluacion
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_criterios_evaluacion=new Tb_criterios_evaluacion();
            $tb_criterios_evaluacion->ideas=$request->ideas;
            $tb_criterios_evaluacion->visibilidad=$request->visibilidad;
            $tb_criterios_evaluacion->idideas=$request->idideas;
            $tb_criterios_evaluacion->estado=1;

            if ($tb_criterios_evaluacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Criterios Evaluacion creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Criterios Evaluacion no pudo ser creado'
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
            $tb_criterios_evaluacion=Tb_criterios_evaluacion::findOrFail($request->id);
            $tb_criterios_evaluacion->ideas=$request->ideas;
            $tb_criterios_evaluacion->visibilidad=$request->visibilidad;
            $tb_criterios_evaluacion->idideas=$request->idideas;
            $tb_criterios_evaluacion->estado='1';

            if ($tb_criterios_evaluacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Criterios Evaluacion actualizado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Criterios Evaluacion no pudo ser actualizado'
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
            $tb_criterios_evaluacion=Tb_criterios_evaluacion::findOrFail($request->id);
            $tb_criterios_evaluacion->estado='0';

            if ($tb_criterios_evaluacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Criterios Evaluacion desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Criterios Evaluacion no pudo ser desactivado'
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
            $tb_criterios_evaluacion=Tb_criterios_evaluacion::findOrFail($request->id);
            $tb_criterios_evaluacion->estado='1';

            if ($tb_criterios_evaluacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Criterios Evaluacion activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Criterios Evaluacion no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
