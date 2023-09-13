<?php

namespace App\Http\Controllers;

use App\Models\Tb_usuario_ideas;
use App\Models\Tb_usuario_criterios;
use App\Models\Tb_relacion_ideas_criterios;
use Illuminate\Http\Request;

class Tb_usuario_criteriosController extends Controller
{
    public function index(Request $request)
    {
        $usuario_criterios = Tb_usuario_criterios::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'usuario_criterios' => $usuario_criterios
        ];
    }

    public function indexOne(Request $request)
    {
        $usuario_criterios = Tb_usuario_criterios::orderBy('id','desc')
        ->where('tb_usuario_criterios.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'usuario_criterios' => $usuario_criterios
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_usuario_criterios=new Tb_usuario_criterios();
            $tb_usuario_criterios->idUsuario=$request->idUsuario;
            $tb_usuario_criterios->idCriterio=$request->idCriterio;

            if ($tb_usuario_criterios->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Usuario criterios creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario criterios no pudo ser creado'
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
            $tb_usuario_criterios=Tb_usuario_criterios::findOrFail($request->id);
            $tb_usuario_criterios->idUsuario=$request->idUsuario;
            $tb_usuario_criterios->idCriterio=$request->idCriterio;

            if ($tb_usuario_criterios->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Usuario criterios actualizado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario criterios no pudo ser actualizado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

    public function closeDeal(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        //Verifico el hobbie de la tabla que corresponda al idHobby y el idUsuario; si existe lo pongo en estado 1, si no, lo creo y pongo en estado 1

        $count_tb_usuario_criterios=Tb_usuario_criterios::where('idCriterio','=',$request->idCriterio)
        ->where('idUsuario','=',$request->idUsuario)
        ->count();

        if($count_tb_usuario_criterios>0){
            $tb_usuario_criterios=Tb_usuario_criterios::where('idCriterio','=',$request->idCriterio)
            ->where('idUsuario','=',$request->idUsuario)
            ->get();

            foreach($tb_usuario_criterios as $vuelta){
                $idBusca = $vuelta->id;
                }

            $tb_usuario_criterios=Tb_usuario_criterios::findOrFail($idBusca);
            $tb_usuario_criterios->estado=1;
            if ($tb_usuario_criterios->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Relacion cerrada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Relacion no pudo ser cerrada'
                   ]);
            }
        }else{
            $tb_usuario_criterios=new Tb_usuario_criterios();
            $tb_usuario_criterios->idUsuario=$request->idUsuario;
            $tb_usuario_criterios->idCriterio=$request->idCriterio;
            $tb_usuario_criterios->estado=1;
            if ($tb_usuario_criterios->save()) {
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

    public function countCriterios(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $count_tb_usuario_criterios=Tb_usuario_criterios::where('idUsuario','=',$request->id)
        ->count();
        return response()->json([
            'estado' => 'Ok',
            'message' => $count_tb_usuario_criterios
           ]);
    }

    public function usuarioCriterios(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $usuario_criterios=Tb_usuario_criterios::join('tb_criterios','tb_criterios.id','=','tb_usuario_criterios.idCriterio')
        ->where('tb_usuario_criterios.idUsuario','=',$request->id)
        ->where('tb_usuario_criterios.estado','=',1)
        ->select('tb_criterios.criterio','tb_criterios.pregunta','tb_usuario_criterios.id')
        ->get();
        return response()->json([
            'estado' => 'Ok',
            'criterios' => $usuario_criterios
           ]);
    }

    public function updateUsuarioCriterios(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_usuario_criterios=Tb_usuario_criterios::findOrFail($request->id);
            $tb_usuario_criterios->porcentaje=($request->value)/100;

            if ($tb_usuario_criterios->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Usuario criterios actualizado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario criterios no pudo ser actualizado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }
    }
}
