<?php

namespace App\Http\Controllers;

use App\Models\Tb_avances_simulacion;
use Illuminate\Http\Request;

class Tb_avances_simulacionController extends Controller
{
    public function index(Request $request)
    {
        $avances_simulacion = Tb_avances_simulacion::orderBy('avances_simulacion','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'avances_simulacion' => $avances_simulacion
        ];
    }

    public function indexOne(Request $request)
    {
        $avances_simulacion = Tb_avances_simulacion::orderBy('avances_simulacion','desc')
        ->where('tb_avances_simulacion.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'avances_simulacion' => $avances_simulacion
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_avances_simulacion=new Tb_avances_simulacion();
            $tb_avances_simulacion->cadena=$request->cadena;
            $tb_avances_simulacion->pregunta=$request->pregunta;
            $tb_avances_simulacion->enunciado=$request->enunciado;
            $tb_avances_simulacion->idUsuario=$request->idUsuario;
            $tb_avances_simulacion->estado=1;

            if ($tb_avances_simulacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'avances_simulacion creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'avances_simulacion no pudo ser creada'
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
            $tb_avances_simulacion=Tb_avances_simulacion::findOrFail($request->id);
            $tb_avances_simulacion->cadena=$request->cadena;
            $tb_avances_simulacion->pregunta=$request->pregunta;
            $tb_avances_simulacion->enunciado=$request->enunciado;
            $tb_avances_simulacion->idUsuario=$request->idUsuario;
            $tb_avances_simulacion->estado='1';

            if ($tb_avances_simulacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'avances_simulacion actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'avances_simulacion no pudo ser actualizada'
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
            $tb_avances_simulacion=Tb_avances_simulacion::findOrFail($request->id);
            $tb_avances_simulacion->estado='0';

            if ($tb_avances_simulacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'avances_simulacion desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'avances_simulacion no pudo ser desactivada'
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
            $tb_avances_simulacion=Tb_avances_simulacion::findOrFail($request->id);
            $tb_avances_simulacion->estado='1';

            if ($tb_avances_simulacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'avances_simulacion activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'avances_simulacion no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
