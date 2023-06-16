<?php

namespace App\Http\Controllers;

use App\Models\Tb_rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_rolController extends Controller
{
    public function index(Request $request)
    {
        $rol = Tb_rol::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'rol' => $rol
        ];
    }

    public function indexOne(Request $request)
    {
        $rol = Tb_rol::orderBy('id','desc')
        ->where('tb_rol.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'rol' => $rol
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_rol=new Tb_rol();
            $tb_rol->rol=$request->rol;
            $tb_rol->estado=1;

            if ($tb_rol->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Rol creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Rol no pudo ser creado'
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
            $tb_rol=Tb_rol::findOrFail($request->id);
            $tb_rol->rol=$request->rol;
            $tb_rol->estado='1';

            if ($tb_rol->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Rol actualizado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Rol no pudo ser actualizado'
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
            $tb_rol=Tb_rol::findOrFail($request->id);
            $tb_rol->estado='0';

            if ($tb_rol->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Rol desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Rol no pudo ser desactivado'
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
            $tb_rol=Tb_rol::findOrFail($request->id);
            $tb_rol->estado='1';

            if ($tb_rol->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Rol activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Rol no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
