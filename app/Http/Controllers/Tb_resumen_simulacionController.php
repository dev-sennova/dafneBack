<?php

namespace App\Http\Controllers;

use App\Models\Tb_resumen_simulacion;
use Illuminate\Http\Request;

class Tb_resumen_simulacionController extends Controller
{
    public function index(Request $request)
    {
        $resumen_simulacion = Tb_resumen_simulacion::orderBy('tb_resumen_simulacion.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'resumen_simulacion' => $resumen_simulacion
        ];
    }

    public function indexOne(Request $request)
    {
        $resumen_simulacion = Tb_resumen_simulacion::orderBy('tb_resumen_simulacion.id','desc')
        ->where('tb_resumen_simulacion.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'resumen_simulacion' => $resumen_simulacion
        ];
    }

    public function indexPropio(Request $request)
    {
        $resumen_simulacion = Tb_resumen_simulacion::orderBy('tb_resumen_simulacion.id','asc')
        ->where('tb_resumen_simulacion.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'resumen_simulacion' => $resumen_simulacion
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_resumen_simulacion=new Tb_resumen_simulacion();
            $tb_resumen_simulacion->idExterno=$request->idExterno;
            $tb_resumen_simulacion->cadena=$request->cadena;
            $tb_resumen_simulacion->pregunta=$request->pregunta;
            $tb_resumen_simulacion->enunciado=$request->enunciado;
            $tb_resumen_simulacion->enlace=$request->enlace;
            $tb_resumen_simulacion->seccion=$request->seccion;
            $tb_resumen_simulacion->idUsuario=$request->idUsuario;
            $tb_resumen_simulacion->estado=1;

            if ($tb_resumen_simulacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'resumen simulacion creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'resumen simulacion no pudo ser creada'
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
            $tb_resumen_simulacion=Tb_resumen_simulacion::findOrFail($request->id);
            $tb_resumen_simulacion->cadena=$request->cadena;
            $tb_resumen_simulacion->pregunta=$request->pregunta;
            $tb_resumen_simulacion->enunciado=$request->enunciado;
            $tb_resumen_simulacion->enlace=$request->enlace;
            $tb_resumen_simulacion->seccion=$request->seccion;
            $tb_resumen_simulacion->idUsuario=$request->idUsuario;
            $tb_resumen_simulacion->estado='1';

            if ($tb_resumen_simulacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'resumen simulacion actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'resumen simulacion no pudo ser actualizada'
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
            $tb_resumen_simulacion=Tb_resumen_simulacion::findOrFail($request->id);
            $tb_resumen_simulacion->estado='0';

            if ($tb_resumen_simulacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'resumen simulacion desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'resumen simulacion no pudo ser desactivada'
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
            $tb_resumen_simulacion=Tb_resumen_simulacion::findOrFail($request->id);
            $tb_resumen_simulacion->estado='1';

            if ($tb_resumen_simulacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'resumen simulacion activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'resumen simulacion no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
