<?php

namespace App\Http\Controllers;

use App\Models\Tb_usuario_suenos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_usuario_suenosController extends Controller
{
    public function index(Request $request)
    {
        $usuario_suenos = Tb_usuario_suenos::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'usuario_suenos' => $usuario_suenos
        ];
    }

    public function indexOne(Request $request)
    {
        $usuario_suenos = Tb_usuario_suenos::orderBy('id','desc')
        ->where('tb_usuario_suenos.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'usuario_suenos' => $usuario_suenos
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_usuario_suenos=new Tb_usuario_suenos();
            $tb_usuario_suenos->prioridad=0;
            $tb_usuario_suenos->idUsuario=$request->idUsuario;
            $tb_usuario_suenos->idSueno=$request->idSueno;

            if ($tb_usuario_suenos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Usuario Sueños creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario Sueños no pudo ser creado'
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
            $tb_usuario_suenos=Tb_usuario_suenos::findOrFail($request->id);
            $tb_usuario_suenos->prioridad=$request->prioridad;
            $tb_usuario_suenos->idUsuario=$request->idUsuario;
            $tb_usuario_suenos->idSueno=$request->idSueno;

            if ($tb_usuario_suenos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Usuario Sueños actualizado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario Sueños no pudo ser actualizado'
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

        $count_tb_usuario_suenos=Tb_usuario_suenos::where('idSueno','=',$request->idSueno)
        ->where('idUsuario','=',$request->idUsuario)
        ->count();

        if($count_tb_usuario_suenos>0){
            $tb_usuario_suenos=Tb_usuario_suenos::where('idSueno','=',$request->idSueno)
            ->where('idUsuario','=',$request->idUsuario)
            ->get();

            foreach($tb_usuario_suenos as $vuelta){
                $idBusca = $vuelta->id;
                }

            $tb_usuario_suenos=Tb_usuario_suenos::findOrFail($idBusca);
            $tb_usuario_suenos->estado=1;
            if ($tb_usuario_suenos->save()) {
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
            $tb_usuario_suenos=new Tb_usuario_suenos();
            $tb_usuario_suenos->prioridad=0;
            $tb_usuario_suenos->idUsuario=$request->idUsuario;
            $tb_usuario_suenos->idSueno=$request->idSueno;
            $tb_usuario_suenos->estado=1;
            if ($tb_usuario_suenos->save()) {
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

    public function countSuenos(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $count_tb_usuario_suenos=Tb_usuario_suenos::where('idUsuario','=',$request->id)
        ->count();
        return response()->json([
            'estado' => 'Ok',
            'message' => $count_tb_usuario_suenos
           ]);
    }

    public function usuarioSuenos(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $usuario_suenos=Tb_usuario_suenos::join('tb_suenos','tb_suenos.id','=','tb_usuario_suenos.idSueno')
        ->where('tb_usuario_suenos.idUsuario','=',$request->id)
        ->where('tb_usuario_suenos.estado','=',1)
        ->select('tb_suenos.sueno','tb_usuario_suenos.id')
        ->get();
        return response()->json([
            'estado' => 'Ok',
            'suenos' => $usuario_suenos
           ]);
    }

    public function updateUsuarioSuenos(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_usuario_suenos=Tb_usuario_suenos::findOrFail($request->id);
            $tb_usuario_suenos->prioridad=$request->value;

            if ($tb_usuario_suenos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Usuario sueños actualizado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario sueños no pudo ser actualizado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }
    }
}
