<?php

namespace App\Http\Controllers;

use App\Models\Tb_directorio;
use Illuminate\Http\Request;

class Tb_directorioController extends Controller
{
    public function index(Request $request)
    {
        $directorio = Tb_directorio::orderBy('directorio','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'directorio' => $directorio
        ];
    }

    public function indexOne(Request $request)
    {
        $directorio = Tb_directorio::orderBy('directorio','desc')
        ->where('tb_directorio.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'directorio' => $directorio
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_directorio=new Tb_directorio();
            $tb_directorio->entidad=$request->entidad;
            $tb_directorio->municipio=$request->municipio;
            $tb_directorio->direccion=$request->direccion;
            $tb_directorio->web=$request->web;
            $tb_directorio->telefonos=$request->telefonos;
            $tb_directorio->chat=$request->chat;
            $tb_directorio->correo=$request->correo;
            $tb_directorio->tipo=$request->tipo;
            $tb_directorio->estado=1;

            if ($tb_directorio->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'directorio creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'directorio no pudo ser creada'
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
            $tb_directorio=Tb_directorio::findOrFail($request->id);
            $tb_directorio->entidad=$request->entidad;
            $tb_directorio->municipio=$request->municipio;
            $tb_directorio->direccion=$request->direccion;
            $tb_directorio->web=$request->web;
            $tb_directorio->telefonos=$request->telefonos;
            $tb_directorio->chat=$request->chat;
            $tb_directorio->correo=$request->correo;
            $tb_directorio->tipo=$request->tipo;
            $tb_directorio->estado=1;

            if ($tb_directorio->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'directorio actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'directorio no pudo ser actualizada'
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
            $tb_directorio=Tb_directorio::findOrFail($request->id);
            $tb_directorio->estado='0';

            if ($tb_directorio->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'directorio desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'directorio no pudo ser desactivada'
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
            $tb_directorio=Tb_directorio::findOrFail($request->id);
            $tb_directorio->estado='1';

            if ($tb_directorio->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'directorio activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'directorio no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
