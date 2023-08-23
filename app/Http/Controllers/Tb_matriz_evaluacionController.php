<?php

namespace App\Http\Controllers;
use App\Models\Tb_matriz_evaluacion;
use Illuminate\Http\Request;

class Tb_matriz_evaluacionController extends Controller
{
    public function index(Request $request)
    {
        $matriz_evaluacion = Tb_matriz_evaluacion::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'matriz_evaluacion' => $matriz_evaluacion
        ];
    }

    public function indexOne(Request $request)
    {
        $matriz_evaluacion = Tb_matriz_evaluacion::orderBy('id','desc')
        ->where('tb_matriz_evaluacion.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'matriz_evaluacion' => $matriz_evaluacion
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_matriz_evaluacion=new Tb_matriz_evaluacion();
            $tb_matriz_evaluacion->porcentaje=$request->valorPorcentajeAcumuladoMatriz;
            $tb_matriz_evaluacion->idUsuarioIdeas=$request->idIdeaMatriz;
            $tb_matriz_evaluacion->nombreIdea=$request->nombreIdeaMatriz;
            $tb_matriz_evaluacion->idUsuario=$request->idUsuario;
            $tb_matriz_evaluacion->estado=1;

            if ($tb_matriz_evaluacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Matriz Evaluacion creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'matriz Evaluacion no pudo ser creado'
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
            $tb_matriz_evaluacion=Tb_matriz_evaluacion::findOrFail($request->id);
            $tb_matriz_evaluacion->porcentaje=$request->valorPorcentajeAcumuladoMatriz;
            $tb_matriz_evaluacion->idUsuarioIdeas=$request->idIdeaMatriz;
            $tb_matriz_evaluacion->nombreIdea=$request->nombreIdeaMatriz;
            $tb_matriz_evaluacion->idUsuario=$request->idUsuario;
            $tb_matriz_evaluacion->estado=1;

            if ($tb_matriz_evaluacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Matriz Evaluacion actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Matriz Evaluacion no pudo ser actualizada'
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
            $tb_matriz_evaluacion=Tb_matriz_evaluacion::findOrFail($request->id);
            $tb_matriz_evaluacion->estado='0';

            if ($tb_matriz_evaluacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Matriz Evaluacion desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Matriz Evaluacion no pudo ser desactivada'
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
            $tb_matriz_evaluacion=Tb_matriz_evaluacion::findOrFail($request->id);
            $tb_matriz_evaluacion->estado='1';

            if ($tb_matriz_evaluacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Matriz Evaluacion activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Matriz Evaluacion no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

}
