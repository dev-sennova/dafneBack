<?php

namespace App\Http\Controllers;

use App\Models\Tb_debilidades_oportunidades;
use Illuminate\Http\Request;

class Tb_debilidades_oportunidadesController extends Controller
{
    public function index(Request $request)
    {
        $debilidades_oportunidades = Tb_debilidades_oportunidades::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'debilidades_oportunidades' => $debilidades_oportunidades
        ];
    }


    public function indexOne(Request $request)
    {
        $debilidades_oportunidades = Tb_debilidades_oportunidades::orderBy('id','desc')
        ->where('tb_debilidades_oportunidades.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'debilidades_oportunidades' => $debilidades_oportunidades
        ];
    }

    public function indexPropio(Request $request)
    {
        //Modelo::join('tablaqueseune',basicamente un on)
        $debilidades_oportunidades = Tb_debilidades_oportunidades::join('tb_usuario','tb_debilidades_oportunidades.idUsuario','=','tb_usuario.id')
        ->where('tb_debilidades_oportunidades.estado','=','1')
        ->where('tb_usuario_debilidades_oportunidades.idUsuario','=',$request->id)
        ->select('tb_debilidades_oportunidades.id','tb_debilidades_oportunidades.accion','tb_debilidades_oportunidades.estrategia','tb_debilidades_oportunidades.idUsuario')
        ->orderBy('tb_debilidades_oportunidades.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'debilidades_oportunidades' => $debilidades_oportunidades
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_debilidades_oportunidades=new Tb_debilidades_oportunidades();
            $tb_debilidades_oportunidades->accion=$request->accion;
            $tb_debilidades_oportunidades->estrategia=$request->estrategia;
            $tb_debilidades_oportunidades->idUsuario=$request->idUsuario;
            $tb_debilidades_oportunidades->estado=1;

            if ($tb_debilidades_oportunidades->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Debilidades vs oportunidades creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Debilidades vs oportunidades no pudo ser creada'
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
            $tb_debilidades_oportunidades=Tb_debilidades_oportunidades::findOrFail($request->id);
            $tb_debilidades_oportunidades->accion=$request->accion;
            $tb_debilidades_oportunidades->estrategia=$request->estrategia;
            $tb_debilidades_oportunidades->idUsuario=$request->idUsuario;
            $tb_debilidades_oportunidades->estado=1;

            if ($tb_debilidades_oportunidades->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Debilidades vs oportunidades actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Debilidades vs oportunidades no pudo ser actualizada'
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
            $tb_debilidades_oportunidades=Tb_debilidades_oportunidades::findOrFail($request->id);
            $tb_debilidades_oportunidades->estado='0';

            if ($tb_debilidades_oportunidades->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Debilidades vs oportunidades desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Debilidades vs oportunidades no pudo ser desactivada'
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
            $tb_debilidades_oportunidades=Tb_debilidades_oportunidades::findOrFail($request->id);
            $tb_debilidades_oportunidades->estado='1';

            if ($tb_debilidades_oportunidades->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Debilidades vs oportunidades activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Debilidades vs oportunidades no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
