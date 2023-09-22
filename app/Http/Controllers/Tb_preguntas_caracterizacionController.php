<?php

namespace App\Http\Controllers;

use App\Models\Tb_preguntas_caracterizacion;
use Illuminate\Http\Request;

class Tb_preguntas_caracterizacionController extends Controller
{
    public function index(Request $request)
    {
        $preguntas_caracterizacion = Tb_preguntas_caracterizacion::orderBy('preguntas_caracterizacion','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'preguntas_caracterizacion' => $preguntas_caracterizacion
        ];
    }

    public function indexOne(Request $request)
    {
        $preguntas_caracterizacion = Tb_preguntas_caracterizacion::orderBy('preguntas_caracterizacion','desc')
        ->where('tb_preguntas_caracterizacion.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'preguntas_caracterizacion' => $preguntas_caracterizacion
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_preguntas_caracterizacion=new Tb_preguntas_caracterizacion();
            $tb_preguntas_caracterizacion->pregunta=$request->pregunta;
            $tb_preguntas_caracterizacion->estado=1;

            if ($tb_preguntas_caracterizacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'preguntas_caracterizacion creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'preguntas_caracterizacion no pudo ser creada'
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
            $tb_preguntas_caracterizacion=Tb_preguntas_caracterizacion::findOrFail($request->id);
            $tb_preguntas_caracterizacion->pregunta=$request->pregunta;
            $tb_preguntas_caracterizacion->estado='1';

            if ($tb_preguntas_caracterizacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'preguntas_caracterizacion actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'preguntas_caracterizacion no pudo ser actualizada'
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
            $tb_preguntas_caracterizacion=Tb_preguntas_caracterizacion::findOrFail($request->id);
            $tb_preguntas_caracterizacion->estado='0';

            if ($tb_preguntas_caracterizacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'preguntas_caracterizacion desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'preguntas_caracterizacion no pudo ser desactivada'
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
            $tb_preguntas_caracterizacion=Tb_preguntas_caracterizacion::findOrFail($request->id);
            $tb_preguntas_caracterizacion->estado='1';

            if ($tb_preguntas_caracterizacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'preguntas_caracterizacion activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'preguntas_caracterizacion no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
