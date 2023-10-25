<?php

namespace App\Http\Controllers;

use App\Models\Tb_estrategias;
use Illuminate\Http\Request;

class Tb_estrategiasController extends Controller
{
    public function index(Request $request)
    {
        $estrategias = Tb_estrategias::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'estrategias' => $estrategias
        ];
    }

    public function indexOne(Request $request)
    {
        $estrategias = Tb_estrategias::orderBy('id','desc')
        ->where('tb_estrategias.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'estrategias' => $estrategias
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_estrategias=new Tb_estrategias();
            $tb_estrategias->accionFO="";
            $tb_estrategias->accionDO="";
            $tb_estrategias->accionFA="";
            $tb_estrategias->accionDA="";
            $tb_estrategias->estrategiaFO="";
            $tb_estrategias->estrategiaDO="";
            $tb_estrategias->estrategiaFA="";
            $tb_estrategias->estrategiaDA="";
            $tb_estrategias->avanceFO='0';
            $tb_estrategias->avanceDO='0';
            $tb_estrategias->avanceFA='0';
            $tb_estrategias->avanceDA='0';
            $tb_estrategias->estado='1';
            $tb_estrategias->idUsuario=$request->idUsuario;

            if ($tb_estrategias->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Matriz estrategias creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Matriz estrategias no pudo ser creada'
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
            $tb_estrategias=Tb_estrategias::findOrFail($request->id);
            $tb_estrategias->accionFO=$request->accionFO;
            $tb_estrategias->accionDO=$request->accionDO;
            $tb_estrategias->accionFA=$request->accionFA;
            $tb_estrategias->accionDA=$request->accionDA;
            $tb_estrategias->estrategiaFO=$request->estrategiaFO;
            $tb_estrategias->estrategiaDO=$request->estrategiaDO;
            $tb_estrategias->estrategiaFA=$request->estrategiaFA;
            $tb_estrategias->estrategiaDA=$request->estrategiaDA;
            $tb_estrategias->avanceFO=$request->avanceFO;
            $tb_estrategias->avanceDO=$request->avanceDO;
            $tb_estrategias->avanceFA=$request->avanceFA;
            $tb_estrategias->avanceDA=$request->avanceDA;
            $tb_estrategias->estado='1';
            $tb_estrategias->idUsuario=$request->idUsuario;

            if ($tb_estrategias->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Matriz estrategias actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Matriz estrategias no pudo ser actualizada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno '.$e], 500);
        }
    }

    public function deactivate(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_estrategias=Tb_estrategias::findOrFail($request->id);
            $tb_estrategias->estado='0';

            if ($tb_estrategias->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Matriz estrategias desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Matriz estrategias no pudo ser desactivada'
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
            $tb_estrategias=Tb_estrategias::findOrFail($request->id);
            $tb_estrategias->estado='1';

            if ($tb_estrategias->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Matriz estrategias activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Matriz estrategias no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
