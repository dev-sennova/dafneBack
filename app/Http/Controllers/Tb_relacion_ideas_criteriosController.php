<?php

namespace App\Http\Controllers;

use App\Models\Tb_ideas;
use App\Models\Tb_usuario_ideas;
use App\Models\Tb_criterios;
use App\Models\Tb_usuario_criterios;
use App\Models\Tb_relacion_ideas_criterios;

use Illuminate\Http\Request;

class Tb_relacion_ideas_criteriosController extends Controller
{
    public function index(Request $request)
    {
        $relacion_ideas_criterios = Tb_relacion_ideas_criterios::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'relacion_ideas_criterios' => $relacion_ideas_criterios
        ];
    }

    public function indexOne(Request $request)
    {
        $relacion_ideas_criterios = Tb_relacion_ideas_criterios::orderBy('id','desc')
        ->where('tb_relacion_ideas_criterios.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'relacion_ideas_criterios' => $relacion_ideas_criterios
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_relacion=new Tb_relacion_ideas_criterios();
            $tb_relacion->idUsuarioIdeas=$request->idUsuarioIdeas;
            $tb_relacion->idUsuarioCriterios=$request->idUsuarioCriterios;
            $tb_relacion->idUsuario=$request->idUsuario;

            if ($tb_relacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Relación Usuario ideas-criterios creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Relación Usuario ideas-criterios no pudo ser creada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

    public function countRelacionIdeasCriterios(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $relacion_ideas_criterios=tb_relacion_ideas_criterios::where('idUsuario','=',$request->id)
        ->count();
        return response()->json([
            'estado' => 'Ok',
            'message' => $relacion_ideas_criterios
           ]);
    }


    public function gestionarRelacionIdeasCriterios(Request $request){
        $usuario_ideas=Tb_usuario_ideas::where('idUsuario','=',$request->idUsuario)
        ->where('estado','=',1)
        ->get();

        $usuario_criterios=Tb_usuario_criterios::where('idUsuario','=',$request->idUsuario)
        ->where('estado','=',1)
        ->get();

    foreach($usuario_ideas as $vueltaexterna){
        $idBuscaExterna = $vueltaexterna->id;
        $this->info('idBuscaExterna: '+$idBuscaExterna);

        foreach($usuario_criterios as $vueltainterna){
                $idBuscaInterna = $vueltainterna->id;
                $this->info('idBuscaInterna: '+$idBuscaInterna);
                $tb_relacion_ideas_criterios=new Tb_relacion_ideas_criterios();
                $tb_relacion_ideas_criterios->porcentaje=0;
                $tb_relacion_ideas_criterios->idUsuarioIdeas=$idBuscaExterna;
                $tb_relacion_ideas_criterios->idUsuarioCriterios=$idBuscaInterna;
                $tb_relacion_ideas_criterios->estado=1;
                if ($tb_relacion_ideas_criterios->save()) {
                    return response()->json([
                        'estado' => 'Ok',
                        'message' => 'Relacion creada y cerrada con éxito'
                    ]);
                } else {
                    return response()->json([
                        'estado' => 'Error',
                        'message' => 'Relacion no pudo ser creada y cerrada'
                    ]);
                }
            }
        }
    }

    public function relacionIdeasCriterios(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $relacion_ideas_criterios=tb_relacion_ideas_criterios::join('tb_criterios','tb_criterios.id','=','tb_relacion_ideas_criterios.idUsuarioCriterios')
        ->where('tb_relacion_ideas_criterios.idUsuario','=',$request->id)
        ->where('tb_relacion_ideas_criterios.estado','=',1)
        ->select('tb_criterios.criterio','tb_relacion_ideas_criterios.id')
        ->get();
        return response()->json([
            'estado' => 'Ok',
            'criterios' => $relacion_ideas_criterios
           ]);
    }

    public function updateRelacionIdeasCriterios(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $relacion_ideas_criterios=tb_relacion_ideas_criterios::findOrFail($request->id);
            $relacion_ideas_criterios->porcentaje=$request->value;

            if ($relacion_ideas_criterios->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Relación ideas criterios actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Relación ideas criterios no pudo ser actualizada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }
    }
}
