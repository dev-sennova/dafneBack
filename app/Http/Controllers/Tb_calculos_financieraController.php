<?php

namespace App\Http\Controllers;

use App\Models\Tb_calculos_financiera;
use Illuminate\Http\Request;

class Tb_calculos_financieraController extends Controller
{
    public function index(Request $request)
    {
        $calculos = Tb_calculos_financiera::orderBy('calculos','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'calculos' => $calculos
        ];
    }

    public function indexOne(Request $request)
    {
        $calculos = Tb_calculos_financiera::orderBy('calculos','desc')
        ->where('tb_calculos_financiera.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'calculos' => $calculos
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_calculos_financiera=new Tb_calculos_financiera();
            $tb_calculos_financiera->calculo=$request->calculo;
            $tb_calculos_financiera->estado=1;

            if ($tb_calculos_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'calculos creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'calculos no pudo ser creada'
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
            $tb_calculos_financiera=Tb_calculos_financiera::findOrFail($request->id);
            $tb_calculos_financiera->calculo=$request->calculo;
            $tb_calculos_financiera->estado='1';

            if ($tb_calculos_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'calculos actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'calculos no pudo ser actualizada'
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
            $tb_calculos_financiera=Tb_calculos_financiera::findOrFail($request->id);
            $tb_calculos_financiera->estado='0';

            if ($tb_calculos_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'calculos desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'calculos no pudo ser desactivada'
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
            $tb_calculos_financiera=Tb_calculos_financiera::findOrFail($request->id);
            $tb_calculos_financiera->estado='1';

            if ($tb_calculos_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'calculos activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'calculos no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
