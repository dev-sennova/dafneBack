<?php

namespace App\Http\Controllers;

use App\Models\Tb_usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_usuarioController extends Controller
{
    public function index(Request $request)
    {
        $users = Tb_usuario::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'users' => $users
        ];
    }

    public function indexOne(Request $request)
    {
        $users = Tb_usuario::orderBy('id','desc')
        ->where('tb_usuario.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'users' => $users
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_usuario=new Tb_usuario();
            $tb_usuario->nombres=$request->nombres;
            $tb_usuario->apellidos=$request->apellidos;
            $tb_usuario->documento=$request->documento;
            $tb_usuario->direccion=$request->direccion;
            $tb_usuario->telefono=$request->telefono;
            $tb_usuario->email=$request->email;
            $tb_usuario->password=$request->password;
            $tb_usuario->estado=1;

            if ($tb_usuario->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Usuario creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario no pudo ser creado'
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
            $tb_usuario=Tb_usuario::findOrFail($request->id);
            $tb_usuario->nombres=$request->nombres;
            $tb_usuario->apellidos=$request->apellidos;
            $tb_usuario->documento=$request->documento;
            $tb_usuario->direccion=$request->direccion;
            $tb_usuario->telefono=$request->telefono;
            $tb_usuario->email=$request->email;
            $tb_usuario->password=$request->password;
            $tb_usuario->estado='1';

            if ($tb_usuario->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Usuario actualizado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario no pudo ser actualizado'
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
            $tb_usuario=Tb_usuario::findOrFail($request->id);
            $tb_usuario->estado='0';

            if ($tb_usuario->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Usuario desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario no pudo ser desactivado'
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
            $tb_usuario=Tb_usuario::findOrFail($request->id);
            $tb_usuario->estado='1';

            if ($tb_usuario->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Usuario activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
