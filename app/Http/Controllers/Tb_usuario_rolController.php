<?php

namespace App\Http\Controllers;

use App\Models\Tb_usuario_rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_usuario_rolController extends Controller
{
    public function index(Request $request)
    {
        $usuario_rol = Tb_usuario_rol::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'usuario_rol' => $usuario_rol
        ];
    }

    public function indexOne(Request $request)
    {
        $usuario_rol = Tb_usuario_rol::orderBy('id','desc')
        ->where('tb_usuario_rol.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'usuario_rol' => $usuario_rol
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_usuario_rol=new Tb_usuario_rol();
            $tb_usuario_rol->idUsuario=$request->idUsuario;
            $tb_usuario_rol->idRol=$request->idRol;

            if ($tb_usuario_rol->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Usuario Rol creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario Rol no pudo ser creado'
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
            $tb_usuario_rol=Tb_usuario_rol::findOrFail($request->id);
            $tb_usuario_rol->idUsuario=$request->idUsuario;
            $tb_usuario_rol->idRol=$request->idRol;

            if ($tb_usuario_rol->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Usuario Rol actualizado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario Rol no pudo ser actualizado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

}
