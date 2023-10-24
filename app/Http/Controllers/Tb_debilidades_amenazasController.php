<?php

namespace App\Http\Controllers;

use App\Models\Tb_debilidades_amenazas;
use Illuminate\Http\Request;

class Tb_debilidades_amenazasController extends Controller
{
    public function index(Request $request)
    {
        $debilidades_amenazas = Tb_debilidades_amenazas::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'debilidades_amenazas' => $debilidades_amenazas
        ];
    }


    public function indexOne(Request $request)
    {
        $debilidades_amenazas = Tb_debilidades_amenazas::orderBy('id','desc')
        ->where('tb_debilidades_amenazas.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'debilidades_amenazas' => $debilidades_amenazas
        ];
    }

    public function indexPropio(Request $request)
    {
        //Modelo::join('tablaqueseune',basicamente un on)
        $debilidades_amenazas = Tb_debilidades_amenazas::join('tb_usuario','tb_debilidades_amenazas.idUsuario','=','tb_usuario.id')
        ->where('tb_debilidades_amenazas.estado','=','1')
        ->where('tb_usuario_debilidades_amenazas.idUsuario','=',$request->id)
        ->select('tb_debilidades_amenazas.id','tb_debilidades_amenazas.accion','tb_debilidades_amenazas.estrategia','tb_debilidades_amenazas.idUsuario')
        ->orderBy('tb_debilidades_amenazas.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'debilidades_amenazas' => $debilidades_amenazas
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_debilidades_amenazas=new Tb_debilidades_amenazas();
            $tb_debilidades_amenazas->accion=$request->accion;
            $tb_debilidades_amenazas->estrategia=$request->estrategia;
            $tb_debilidades_amenazas->idUsuario=$request->idUsuario;
            $tb_debilidades_amenazas->estado=1;

            if ($tb_debilidades_amenazas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Debilidades vs Amenazas creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Debilidades vs Amenazas no pudo ser creada'
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
            $tb_debilidades_amenazas=Tb_debilidades_amenazas::findOrFail($request->id);
            $tb_debilidades_amenazas->accion=$request->accion;
            $tb_debilidades_amenazas->estrategia=$request->estrategia;
            $tb_debilidades_amenazas->idUsuario=$request->idUsuario;
            $tb_debilidades_amenazas->estado=1;

            if ($tb_debilidades_amenazas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Debilidades vs Amenazas actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Debilidades vs Amenazas no pudo ser actualizada'
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
            $tb_debilidades_amenazas=Tb_debilidades_amenazas::findOrFail($request->id);
            $tb_debilidades_amenazas->estado='0';

            if ($tb_debilidades_amenazas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Debilidades vs Amenazas desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Debilidades vs Amenazas no pudo ser desactivada'
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
            $tb_debilidades_amenazas=Tb_debilidades_amenazas::findOrFail($request->id);
            $tb_debilidades_amenazas->estado='1';

            if ($tb_debilidades_amenazas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Debilidades vs Amenazas activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Debilidades vs Amenazas no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
