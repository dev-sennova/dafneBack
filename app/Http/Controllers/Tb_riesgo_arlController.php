<?php

namespace App\Http\Controllers;

use App\Models\Tb_riesgo_arl;
use Illuminate\Http\Request;

class Tb_riesgo_arlController extends Controller
{
    public function index(Request $request)
    {
        $riesgo_arl = Tb_riesgo_arl::orderBy('tb_riesgo_arl.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'riesgo_arl' => $riesgo_arl
        ];
    }

    public function indexOne(Request $request)
    {
        $riesgo_arl = Tb_riesgo_arl::orderBy('tb_riesgo_arl.id','desc')
        ->where('tb_riesgo_arl.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'riesgo_arl' => $riesgo_arl
        ];
    }

    public function indexPropio(Request $request)
    {
        $riesgo_arl = Tb_riesgo_arl::orderBy('tb_riesgo_arl.id','asc')
        ->where('tb_riesgo_arl.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'riesgo_arl' => $riesgo_arl
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_riesgo_arl=new Tb_riesgo_arl();
            $tb_riesgo_arl->idExterno=$request->idExterno;
            $tb_riesgo_arl->riesgo=$request->riesgo;
            $tb_riesgo_arl->porcentaje=$request->porcentaje;
            $tb_riesgo_arl->estado=1;

            if ($tb_riesgo_arl->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'riesgo arl creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'riesgo arl no pudo ser creada'
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
            $tb_riesgo_arl=Tb_riesgo_arl::findOrFail($request->id);
            $tb_riesgo_arl->riesgo=$request->riesgo;
            $tb_riesgo_arl->porcentaje=$request->porcentaje;
            $tb_riesgo_arl->estado=1;

            if ($tb_riesgo_arl->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'riesgo arl actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'riesgo arl no pudo ser actualizada'
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
            $tb_riesgo_arl=Tb_riesgo_arl::findOrFail($request->id);
            $tb_riesgo_arl->estado='0';

            if ($tb_riesgo_arl->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'riesgo arl desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'riesgo arl no pudo ser desactivada'
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
            $tb_riesgo_arl=Tb_riesgo_arl::findOrFail($request->id);
            $tb_riesgo_arl->estado='1';

            if ($tb_riesgo_arl->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'riesgo arl activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'riesgo arl no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
