<?php

namespace App\Http\Controllers;

use App\Models\Tb_usuario_ideas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_usuario_ideas_ideasController extends Controller
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
            $tb_usuario_ideas->ideideas=$request->ideideas;

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
            $tb_usuario_ideas->idideas=$request->idideas;

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

}
