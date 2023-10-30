<?php

namespace App\Http\Controllers;

use App\Models\Tb_procesos_financiera;
use Illuminate\Http\Request;

class Tb_procesos_financieraController extends Controller
{
    public function index(Request $request)
    {
        $procesos = Tb_procesos_financiera::orderBy('procesos','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'procesos' => $procesos
        ];
    }

    public function indexOne(Request $request)
    {
        $procesos = Tb_procesos_financiera::orderBy('procesos','desc')
        ->where('tb_procesos_financiera.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'procesos' => $procesos
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_procesos_financiera=new Tb_procesos_financiera();
            $tb_procesos_financiera->proceso=$request->proceso;
            $tb_procesos_financiera->estado=1;

            if ($tb_procesos_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'procesos creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'procesos no pudo ser creada'
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
            $tb_procesos_financiera=Tb_procesos_financiera::findOrFail($request->id);
            $tb_procesos_financiera->proceso=$request->proceso;
            $tb_procesos_financiera->estado='1';

            if ($tb_procesos_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'procesos actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'procesos no pudo ser actualizada'
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
            $tb_procesos_financiera=Tb_procesos_financiera::findOrFail($request->id);
            $tb_procesos_financiera->estado='0';

            if ($tb_procesos_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'procesos desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'procesos no pudo ser desactivada'
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
            $tb_procesos_financiera=Tb_procesos_financiera::findOrFail($request->id);
            $tb_procesos_financiera->estado='1';

            if ($tb_procesos_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'procesos activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'procesos no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
