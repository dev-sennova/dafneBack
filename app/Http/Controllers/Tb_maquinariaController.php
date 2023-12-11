<?php

namespace App\Http\Controllers;

use App\Models\Tb_maquinaria;
use Illuminate\Http\Request;

class Tb_maquinariaController extends Controller
{
    public function index(Request $request)
    {
        $maquinaria = Tb_maquinaria::orderBy('tb_maquinaria.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'maquinaria' => $maquinaria
        ];
    }

    public function indexOne(Request $request)
    {
        $maquinaria = Tb_maquinaria::orderBy('tb_maquinaria.id','desc')
        ->where('tb_maquinaria.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'maquinaria' => $maquinaria
        ];
    }

    public function indexPropio(Request $request)
    {
        $maquinaria = Tb_maquinaria::orderBy('tb_maquinaria.id','asc')
        ->where('tb_maquinaria.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'maquinaria' => $maquinaria
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $valorMaquinaria=$request->valor;
            $tiempoVidaUtil=$request->vidaUtil;

            if($tiempoVidaUtil>0){
                $depreciacionAnual=$valorMaquinaria/$tiempoVidaUtil;
            }else{
                $depreciacionAnual=0;
            }

            $depreciacionMensual=$depreciacionAnual/12;

            $tb_maquinaria=new Tb_maquinaria();
            $tb_maquinaria->maquinaria=$request->maquinaria;
            $tb_maquinaria->valor=$request->valor;
            $tb_maquinaria->vidaUtil=$request->vidaUtil;
            $tb_maquinaria->depreciacion=$depreciacionMensual;
            $tb_maquinaria->idUsuario=$request->idUsuario;
            $tb_maquinaria->estado=1;

            if ($tb_maquinaria->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'maquinaria creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'maquinaria no pudo ser creada'
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
            $valorMaquinaria=$request->valor;
            $tiempoVidaUtil=$request->vidaUtil;

            if($tiempoVidaUtil>0){
                $depreciacionAnual=$valorMaquinaria/$tiempoVidaUtil;
            }else{
                $depreciacionAnual=0;
            }

            $depreciacionMensual=$depreciacionAnual/12;

            $tb_maquinaria=Tb_maquinaria::findOrFail($request->id);
            $tb_maquinaria->maquinaria=$request->maquinaria;
            $tb_maquinaria->valor=$request->valor;
            $tb_maquinaria->vidaUtil=$request->vidaUtil;
            $tb_maquinaria->depreciacion=$depreciacionMensual;
            $tb_maquinaria->idUsuario=$request->idUsuario;
            $tb_maquinaria->estado=1;

            if ($tb_maquinaria->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'maquinaria actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'maquinaria no pudo ser actualizada'
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
            $tb_maquinaria=Tb_maquinaria::findOrFail($request->id);
            $tb_maquinaria->estado='0';

            if ($tb_maquinaria->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'maquinaria desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'maquinaria no pudo ser desactivada'
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
            $tb_maquinaria=Tb_maquinaria::findOrFail($request->id);
            $tb_maquinaria->estado='1';

            if ($tb_maquinaria->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'maquinaria activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'maquinaria no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
