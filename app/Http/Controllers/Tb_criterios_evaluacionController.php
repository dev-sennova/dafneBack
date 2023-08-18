<?php

namespace App\Http\Controllers;

use App\Models\Tb_criterios_evaluacion;
use App\Models\Tb_usuario;
use App\Models\Tb_usuario_criterios;
use App\Models\Tb_usuario_ideas;
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
            $tb_criterios_evaluacion->porcentaje=$request->porcentaje;
            $tb_criterios_evaluacion->idCriterio=$request->idCriterio;
            $tb_criterios_evaluacion->idIdea=$request->idIdea;
            $tb_criterios_evaluacion->idUsuario=$request->idUsuario;
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
            $tb_criterios_evaluacion->porcentaje=$request->porcentaje;
            $tb_criterios_evaluacion->idCriterio=$request->idCriterio;
            $tb_criterios_evaluacion->idIdea=$request->idIdea;
            $tb_criterios_evaluacion->estado=1;

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

    public function calcularMatriz(Request $request)
    {
    try {
        $ideas_usuario = Tb_usuario_ideas::join('tb_ideas','tb_usuario_ideas.idideas','=','tb_ideas.id')
        ->select('tb_usuario_ideas.id', 'tb_ideas.idea')
        ->orderBy('tb_usuario_ideas.idideas','asc')
        ->where('tb_usuario_ideas.idUsuario','=',$request->id)
        ->where('tb_usuario_ideas.estado','=',1)
        ->get();

        $resultado = []; // Arreglo para almacenar los resultados

        foreach($ideas_usuario as $vueltaIdeas){ //voy a tomar idea por idea del usuario para traer los porcentajes asociados en la siguiente iteración
            $nombreIdea = $vueltaIdeas->idea;
            $idBuscaIdea = $vueltaIdeas->id;
            $valorPorcentajeAcumulado=0;

            $criterios_evaluacion_idea = Tb_criterios_evaluacion::select('tb_criterios_evaluacion.porcentaje', 'tb_criterios_evaluacion.idCriterio')
            ->orderBy('tb_criterios_evaluacion.idCriterio','asc')
            ->where('tb_criterios_evaluacion.idUsuario','=',$request->id)
            ->where('tb_criterios_evaluacion.idIdea','=',$idBuscaIdea)
            ->get();

            foreach($criterios_evaluacion_idea as $vueltaCriterio){//voy a tomar criterio por criterio del usuario para recrear la funcion sumaproducto
                $porcentajeCriterioEvaluacion = $vueltaCriterio->porcentaje;
                $idBuscaCriterio = $vueltaCriterio->idCriterio;

                $tb_usuario_criterios = Tb_usuario_criterios::select('tb_usuario_criterios.porcentaje')
                ->where('tb_usuario_criterios.idUsuario','=',$request->id)
                ->where('tb_usuario_criterios.id','=',$idBuscaCriterio)
                ->get();

                foreach($tb_usuario_criterios as $vueltaUsuarioCriterio){
                    $porcentajeCriterio = $vueltaUsuarioCriterio->porcentaje;
                    $valorVuelta=($porcentajeCriterioEvaluacion/100)*($porcentajeCriterio/100);
                    $valorPorcentajeAcumulado=$valorPorcentajeAcumulado+$valorVuelta;
                    }
                }

                $resultado[] = [
                    'idIdeaUsuario' => $idBuscaIdea,
                    'nombreIdea' => $nombreIdea,
                    'valorPorcentajeAcumulado' => $valorPorcentajeAcumulado
                ];

            }
            return response()->json([
                'estado' => 'Ok',
                'criterios_evaluacion' => $resultado
               ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }
    }
}
