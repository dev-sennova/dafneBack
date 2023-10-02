<?php

namespace App\Http\Controllers;

use App\Models\Tb_secciones;
use Illuminate\Http\Request;

class Tb_seccionesController extends Controller
{
    public function index(Request $request)
    {
        $secciones = Tb_secciones::orderBy('secciones','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'secciones' => $secciones
        ];
    }

    public function indexOne(Request $request)
    {
        $secciones = Tb_secciones::orderBy('secciones','desc')
        ->where('tb_secciones.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'secciones' => $secciones
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_secciones=new Tb_secciones();
            $tb_secciones->seccion=$request->seccion;
            $tb_secciones->idModulo=$request->idModulo;
            $tb_secciones->estado=1;

            if ($tb_secciones->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'secciones creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'secciones no pudo ser creada'
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
            $tb_secciones=Tb_secciones::findOrFail($request->id);
            $tb_secciones->seccion=$request->seccion;
            $tb_secciones->idModulo=$request->idModulo;
            $tb_secciones->estado='1';

            if ($tb_secciones->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'secciones actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'secciones no pudo ser actualizada'
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
            $tb_secciones=Tb_secciones::findOrFail($request->id);
            $tb_secciones->estado='0';

            if ($tb_secciones->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'secciones desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'secciones no pudo ser desactivada'
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
            $tb_secciones=Tb_secciones::findOrFail($request->id);
            $tb_secciones->estado='1';

            if ($tb_secciones->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'secciones activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'secciones no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
