<?php

namespace App\Http\Controllers;

use App\Models\Tb_fortalezas_oportunidades;
use Illuminate\Http\Request;

class Tb_fortalezas_oportunidadesController extends Controller
{
    public function index(Request $request)
    {
        $fortalezas_oportunidades = Tb_fortalezas_oportunidades::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'fortalezas_oportunidades' => $fortalezas_oportunidades
        ];
    }


    public function indexOne(Request $request)
    {
        $fortalezas_oportunidades = Tb_fortalezas_oportunidades::orderBy('id','desc')
        ->where('tb_fortalezas_oportunidades.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'fortalezas_oportunidades' => $fortalezas_oportunidades
        ];
    }

    public function indexPropio(Request $request)
    {
        //Modelo::join('tablaqueseune',basicamente un on)
        $fortalezas_oportunidades = Tb_fortalezas_oportunidades::join('tb_usuario','tb_fortalezas_oportunidades.idUsuario','=','tb_usuario.id')
        ->where('tb_fortalezas_oportunidades.estado','=','1')
        ->where('tb_usuario_fortalezas_oportunidades.idUsuario','=',$request->id)
        ->select('tb_fortalezas_oportunidades.id','tb_fortalezas_oportunidades.accion','tb_fortalezas_oportunidades.estrategia','tb_fortalezas_oportunidades.idUsuario')
        ->orderBy('tb_fortalezas_oportunidades.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'fortalezas_oportunidades' => $fortalezas_oportunidades
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_fortalezas_oportunidades=new Tb_fortalezas_oportunidades();
            $tb_fortalezas_oportunidades->accion=$request->accion;
            $tb_fortalezas_oportunidades->estrategia=$request->estrategia;
            $tb_fortalezas_oportunidades->idUsuario=$request->idUsuario;
            $tb_fortalezas_oportunidades->estado=1;

            if ($tb_fortalezas_oportunidades->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'fortalezas vs oportunidades creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'fortalezas vs oportunidades no pudo ser creada'
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
            $tb_fortalezas_oportunidades=Tb_fortalezas_oportunidades::findOrFail($request->id);
            $tb_fortalezas_oportunidades->accion=$request->accion;
            $tb_fortalezas_oportunidades->estrategia=$request->estrategia;
            $tb_fortalezas_oportunidades->idUsuario=$request->idUsuario;
            $tb_fortalezas_oportunidades->estado=1;

            if ($tb_fortalezas_oportunidades->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'fortalezas vs oportunidades actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'fortalezas vs oportunidades no pudo ser actualizada'
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
            $tb_fortalezas_oportunidades=Tb_fortalezas_oportunidades::findOrFail($request->id);
            $tb_fortalezas_oportunidades->estado='0';

            if ($tb_fortalezas_oportunidades->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'fortalezas vs oportunidades desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'fortalezas vs oportunidades no pudo ser desactivada'
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
            $tb_fortalezas_oportunidades=Tb_fortalezas_oportunidades::findOrFail($request->id);
            $tb_fortalezas_oportunidades->estado='1';

            if ($tb_fortalezas_oportunidades->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'fortalezas vs oportunidades activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'fortalezas vs oportunidades no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
