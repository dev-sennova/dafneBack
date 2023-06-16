<?php

namespace App\Http\Controllers;

use App\Models\Tb_usuario_hobbies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_usuario_hobbies_hobbiesController extends Controller
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

}
