<?php

namespace App\Http\Controllers;

use App\Models\Tb_salidas_financiera;
use Illuminate\Http\Request;

class Tb_salida_financieraController extends Controller
{
    public function index(Request $request)
    {
        $salidas = Tb_salidas_financiera::orderBy('salidas','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'salidas' => $salidas
        ];
    }

    public function indexOne(Request $request)
    {
        $salidas = Tb_salidas_financiera::orderBy('salidas','desc')
        ->where('tb_salidas_financiera.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'salidas' => $salidas
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_salidas_financiera=new Tb_salidas_financiera();
            $tb_salidas_financiera->salida=$request->salida;
            $tb_salidas_financiera->estado=1;

            if ($tb_salidas_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'salidas creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'salidas no pudo ser creada'
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
            $tb_salidas_financiera=Tb_salidas_financiera::findOrFail($request->id);
            $tb_salidas_financiera->salida=$request->salida;
            $tb_salidas_financiera->estado='1';

            if ($tb_salidas_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'salidas actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'salidas no pudo ser actualizada'
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
            $tb_salidas_financiera=Tb_salidas_financiera::findOrFail($request->id);
            $tb_salidas_financiera->estado='0';

            if ($tb_salidas_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'salidas desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'salidas no pudo ser desactivada'
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
            $tb_salidas_financiera=Tb_salidas_financiera::findOrFail($request->id);
            $tb_salidas_financiera->estado='1';

            if ($tb_salidas_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'salidas activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'salidas no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
