<?php

namespace App\Http\Controllers;

use App\Models\Tb_perfiles_empresa;
use Illuminate\Http\Request;

class Tb_perfiles_empresaController extends Controller
{
    public function index(Request $request)
    {
        $perfiles_empresa = Tb_perfiles_empresa::orderBy('tb_perfiles_empresa.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'perfiles_empresa' => $perfiles_empresa
        ];
    }

    public function indexOne(Request $request)
    {
        $perfiles_empresa = Tb_perfiles_empresa::orderBy('tb_perfiles_empresa.id','desc')
        ->where('tb_perfiles_empresa.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'perfiles_empresa' => $perfiles_empresa
        ];
    }

    public function indexPropio(Request $request)
    {
        $perfiles_empresa = Tb_perfiles_empresa::orderBy('tb_perfiles_empresa.id','asc')
        ->where('tb_perfiles_empresa.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'perfiles_empresa' => $perfiles_empresa
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_perfiles_empresa=new Tb_perfiles_empresa();
            $tb_perfiles_empresa->perfil=$request->perfil;
            $tb_perfiles_empresa->precio=$request->precio;
            $tb_perfiles_empresa->idUsuario=$request->idUsuario;
            $tb_perfiles_empresa->estado=1;

            if ($tb_perfiles_empresa->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'perfiles empresa creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'perfiles empresa no pudo ser creada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno: '.$e], 500);
        }

    }

    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_perfiles_empresa=Tb_perfiles_empresa::findOrFail($request->id);
            $tb_perfiles_empresa->perfil=$request->perfil;
            $tb_perfiles_empresa->precio=$request->precio;
            $tb_perfiles_empresa->idUsuario=$request->idUsuario;
            $tb_perfiles_empresa->estado=1;

            if ($tb_perfiles_empresa->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'perfiles empresa actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'perfiles empresa no pudo ser actualizada'
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
            $tb_perfiles_empresa=Tb_perfiles_empresa::findOrFail($request->id);
            $tb_perfiles_empresa->estado='0';

            if ($tb_perfiles_empresa->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'perfiles empresa desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'perfiles empresa no pudo ser desactivada'
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
            $tb_perfiles_empresa=Tb_perfiles_empresa::findOrFail($request->id);
            $tb_perfiles_empresa->estado='1';

            if ($tb_perfiles_empresa->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'perfiles empresa activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'perfiles empresa no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
