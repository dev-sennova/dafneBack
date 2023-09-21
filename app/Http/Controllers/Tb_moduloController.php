<?php

namespace App\Http\Controllers;

use App\Models\Tb_modulo;
use Illuminate\Http\Request;

class Tb_moduloController extends Controller
{
    public function index(Request $request)
    {
        $modulo = Tb_modulo::orderBy('modulo','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'modulo' => $modulo
        ];
    }

    public function indexOne(Request $request)
    {
        $modulo = Tb_modulo::orderBy('modulo','desc')
        ->where('tb_modulo.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'modulo' => $modulo
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_modulo=new Tb_modulo();
            $tb_modulo->modulo=$request->modulo;
            $tb_modulo->estado=1;

            if ($tb_modulo->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'modulo creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'modulo no pudo ser creada'
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
            $tb_modulo=Tb_modulo::findOrFail($request->id);
            $tb_modulo->modulo=$request->modulo;
            $tb_modulo->estado='1';

            if ($tb_modulo->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'modulo actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'modulo no pudo ser actualizada'
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
            $tb_modulo=Tb_modulo::findOrFail($request->id);
            $tb_modulo->estado='0';

            if ($tb_modulo->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'modulo desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'modulo no pudo ser desactivada'
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
            $tb_modulo=Tb_modulo::findOrFail($request->id);
            $tb_modulo->estado='1';

            if ($tb_modulo->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'modulo activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'modulo no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
