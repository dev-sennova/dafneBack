<?php

namespace App\Http\Controllers;

use App\Models\Tb_codigo_ciiu;
use Illuminate\Http\Request;

class Tb_codigo_ciiuController extends Controller
{
    public function index(Request $request)
    {
        $codigo_ciiu = Tb_codigo_ciiu::orderBy('tb_codigo_ciiu.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'codigo_ciiu' => $codigo_ciiu
        ];
    }

    public function indexOne(Request $request)
    {
        $codigo_ciiu = Tb_codigo_ciiu::orderBy('tb_codigo_ciiu.id','desc')
        ->where('tb_codigo_ciiu.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'codigo_ciiu' => $codigo_ciiu
        ];
    }

    public function indexPropio(Request $request)
    {
        $codigo_ciiu = Tb_codigo_ciiu::orderBy('tb_codigo_ciiu.id','asc')
        ->where('tb_codigo_ciiu.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'codigo_ciiu' => $codigo_ciiu
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_codigo_ciiu=new Tb_codigo_ciiu();
            $tb_codigo_ciiu->idExterno=$request->idExterno;
            $tb_codigo_ciiu->descripcion=$request->descripcion;
            $tb_codigo_ciiu->codigo=$request->codigo;
            $tb_codigo_ciiu->riesgo=$request->riesgo;
            $tb_codigo_ciiu->estado=1;

            if ($tb_codigo_ciiu->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'codigo ciiu creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'codigo ciiu no pudo ser creada'
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
            $tb_codigo_ciiu=Tb_codigo_ciiu::findOrFail($request->id);
            $tb_codigo_ciiu->descripcion=$request->descripcion;
            $tb_codigo_ciiu->codigo=$request->codigo;
            $tb_codigo_ciiu->riesgo=$request->riesgo;
            $tb_codigo_ciiu->estado=1;

            if ($tb_codigo_ciiu->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'codigo ciiu actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'codigo ciiu no pudo ser actualizada'
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
            $tb_codigo_ciiu=Tb_codigo_ciiu::findOrFail($request->id);
            $tb_codigo_ciiu->estado='0';

            if ($tb_codigo_ciiu->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'codigo ciiu desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'codigo ciiu no pudo ser desactivada'
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
            $tb_codigo_ciiu=Tb_codigo_ciiu::findOrFail($request->id);
            $tb_codigo_ciiu->estado='1';

            if ($tb_codigo_ciiu->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'codigo ciiu activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'codigo ciiu no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
