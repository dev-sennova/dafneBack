<?php

namespace App\Http\Controllers;

use App\Models\Tb_ideas;
use App\Models\Tb_usuario_ideas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_usuario_ideasController extends Controller
{
    public function index(Request $request)
    {
        $usuario_ideas = Tb_usuario_ideas::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'usuario_ideas' => $usuario_ideas
        ];
    }

    public function indexOne(Request $request)
    {
        $usuario_ideas = Tb_usuario_ideas::orderBy('id','desc')
        ->where('tb_usuario_ideas.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'usuario_ideas' => $usuario_ideas
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_usuario_ideas=new Tb_usuario_ideas();
            $tb_usuario_ideas->idUsuario=$request->idUsuario;
            $tb_usuario_ideas->idideas=$request->idIdea;

            if ($tb_usuario_ideas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Usuario Ideas creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario Ideas no pudo ser creado'
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
            $tb_usuario_ideas=Tb_usuario_ideas::findOrFail($request->id);
            $tb_usuario_ideas->idUsuario=$request->idUsuario;
            $tb_usuario_ideas->idideas=$request->idIdea;

            if ($tb_usuario_ideas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Usuario Ideas actualizado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario Ideas no pudo ser actualizado'
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

        $count_tb_usuario_ideas=Tb_usuario_ideas::where('idideas','=',$request->idIdea)
        ->where('idUsuario','=',$request->idUsuario)
        ->count();

        if($count_tb_usuario_ideas>0){
            $tb_usuario_ideas=Tb_usuario_ideas::where('idideas','=',$request->idIdea)
            ->where('idUsuario','=',$request->idUsuario)
            ->get();

            foreach($tb_usuario_ideas as $vuelta){
                $idBusca = $vuelta->id;
                }

            $tb_usuario_ideas=Tb_usuario_ideas::findOrFail($idBusca);
            $tb_usuario_ideas->estado=1;
            if ($tb_usuario_ideas->save()) {
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
            $tb_usuario_ideas=new Tb_usuario_ideas();
            $tb_usuario_ideas->idUsuario=$request->idUsuario;
            $tb_usuario_ideas->idideas=$request->idIdea;
            $tb_usuario_ideas->estado=1;
            if ($tb_usuario_ideas->save()) {
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

    public function countIdeas(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $count_tb_usuario_ideas=Tb_usuario_ideas::where('idUsuario','=',$request->id)
        ->count();
        return response()->json([
            'estado' => 'Ok',
            'message' => $count_tb_usuario_ideas
           ]);
    }

    public function usuarioIdeas(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $usuario_ideas=Tb_usuario_ideas::join('tb_ideas','tb_ideas.id','=','tb_usuario_ideas.idideas')
        ->where('tb_usuario_ideas.idUsuario','=',$request->id)
        ->where('tb_usuario_ideas.estado','=',1)
        ->select('tb_ideas.idea','tb_usuario_ideas.id')
        ->get();
        return response()->json([
            'estado' => 'Ok',
            'ideas' => $usuario_ideas
           ]);
    }

    public function updateUsuarioIdeas(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_usuario_ideas=Tb_usuario_ideas::findOrFail($request->id);

            if ($tb_usuario_ideas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Usuario ideas actualizado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario ideas no pudo ser actualizado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }
    }
}
