<?php

namespace App\Http\Controllers;

use App\Models\Tb_fortalezas_amenazas;
use Illuminate\Http\Request;

class Tb_fortalezas_amenazasController extends Controller
{
    public function index(Request $request)
    {
        $fortalezas_amenazas = Tb_fortalezas_amenazas::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'fortalezas_amenazas' => $fortalezas_amenazas
        ];
    }


    public function indexOne(Request $request)
    {
        $fortalezas_amenazas = Tb_fortalezas_amenazas::orderBy('id','desc')
        ->where('tb_fortalezas_amenazas.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'fortalezas_amenazas' => $fortalezas_amenazas
        ];
    }

    public function indexPropio(Request $request)
    {
        //Modelo::join('tablaqueseune',basicamente un on)
        $fortalezas_amenazas = Tb_fortalezas_amenazas::join('tb_usuario','tb_fortalezas_amenazas.idUsuario','=','tb_usuario.id')
        ->where('tb_fortalezas_amenazas.estado','=','1')
        ->where('tb_usuario_fortalezas_amenazas.idUsuario','=',$request->id)
        ->select('tb_fortalezas_amenazas.id','tb_fortalezas_amenazas.accion','tb_fortalezas_amenazas.estrategia','tb_fortalezas_amenazas.idUsuario')
        ->orderBy('tb_fortalezas_amenazas.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'fortalezas_amenazas' => $fortalezas_amenazas
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_fortalezas_amenazas=new Tb_fortalezas_amenazas();
            $tb_fortalezas_amenazas->accion=$request->accion;
            $tb_fortalezas_amenazas->estrategia=$request->estrategia;
            $tb_fortalezas_amenazas->idUsuario=$request->idUsuario;
            $tb_fortalezas_amenazas->estado=1;

            if ($tb_fortalezas_amenazas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'fortalezas vs amenazas creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'fortalezas vs amenazas no pudo ser creada'
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
            $tb_fortalezas_amenazas=Tb_fortalezas_amenazas::findOrFail($request->id);
            $tb_fortalezas_amenazas->accion=$request->accion;
            $tb_fortalezas_amenazas->estrategia=$request->estrategia;
            $tb_fortalezas_amenazas->idUsuario=$request->idUsuario;
            $tb_fortalezas_amenazas->estado=1;

            if ($tb_fortalezas_amenazas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'fortalezas vs amenazas actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'fortalezas vs amenazas no pudo ser actualizada'
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
            $tb_fortalezas_amenazas=Tb_fortalezas_amenazas::findOrFail($request->id);
            $tb_fortalezas_amenazas->estado='0';

            if ($tb_fortalezas_amenazas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'fortalezas vs amenazas desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'fortalezas vs amenazas no pudo ser desactivada'
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
            $tb_fortalezas_amenazas=Tb_fortalezas_amenazas::findOrFail($request->id);
            $tb_fortalezas_amenazas->estado='1';

            if ($tb_fortalezas_amenazas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'fortalezas vs amenazas activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'fortalezas vs amenazas no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
