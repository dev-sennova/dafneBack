<?php

namespace App\Http\Controllers;

use App\Models\Tb_usuario_hobbies;
use App\Models\Tb_hobbies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_usuario_hobbiesController extends Controller
{
    public function index(Request $request)
    {
        $usuario_hobbies = Tb_usuario_hobbies::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'usuario_hobbies' => $usuario_hobbies
        ];
    }

    public function indexOne(Request $request)
    {
        $usuario_hobbies = Tb_usuario_hobbies::orderBy('id','desc')
        ->where('tb_usuario_hobbies.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'usuario_hobbies' => $usuario_hobbies
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_usuario_hobbies=new Tb_usuario_hobbies();
            $tb_usuario_hobbies->idUsuario=$request->idUsuario;
            $tb_usuario_hobbies->idHobby=$request->idHobby;

            if ($tb_usuario_hobbies->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Usuario Hobbies creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario Hobbies no pudo ser creado'
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
            $tb_usuario_hobbies=Tb_usuario_hobbies::findOrFail($request->id);
            $tb_usuario_hobbies->idUsuario=$request->idUsuario;
            $tb_usuario_hobbies->idHobby=$request->idHobby;

            if ($tb_usuario_hobbies->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Usuario Hobbies actualizado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario Hobbies no pudo ser actualizado'
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

        $count_tb_usuario_hobbies=Tb_usuario_hobbies::where('idHobby','=',$request->idHobby)
        ->where('idUsuario','=',$request->idUsuario)
        ->count();

        if($count_tb_usuario_hobbies>0){
            $tb_usuario_hobbies=Tb_usuario_hobbies::where('idHobby','=',$request->idHobby)
            ->where('idUsuario','=',$request->idUsuario)
            ->get();

            foreach($tb_usuario_hobbies as $vuelta){
                $idBusca = $vuelta->id;
                }

            $tb_usuario_hobbies=Tb_usuario_hobbies::findOrFail($idBusca);
            $tb_usuario_hobbies->estado=1;
            if ($tb_usuario_hobbies->save()) {
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
            $tb_usuario_hobbies=new Tb_usuario_hobbies();
            $tb_usuario_hobbies->idUsuario=$request->idUsuario;
            $tb_usuario_hobbies->idHobby=$request->idHobby;
            $tb_usuario_hobbies->estado=1;
            if ($tb_usuario_hobbies->save()) {
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

    public function countHobbies(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $count_tb_usuario_hobbies=Tb_usuario_hobbies::where('idUsuario','=',$request->id)
        ->count();
        return response()->json([
            'estado' => 'Ok',
            'message' => $count_tb_usuario_hobbies
           ]);
    }

    public function usuarioHobbies(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $usuario_hobbies=Tb_usuario_hobbies::join('tb_hobbies','tb_hobbies.id','=','tb_usuario_hobbies.idHobby')
        ->where('tb_usuario_hobbies.idUsuario','=',$request->id)
        ->where('tb_usuario_hobbies.estado','=',1)
        ->select('tb_hobbies.hobby','tb_usuario_hobbies.id')
        ->get();
        return response()->json([
            'estado' => 'Ok',
            'hobbies' => $usuario_hobbies
           ]);
    }

    public function updateUsuarioHobbies(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_usuario_hobbies=Tb_usuario_hobbies::findOrFail($request->id);
            $tb_usuario_hobbies->prioridad=$request->value;

            if ($tb_usuario_hobbies->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Usuario Hobbies actualizado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario Hobbies no pudo ser actualizado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
