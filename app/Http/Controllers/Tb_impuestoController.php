<?php

namespace App\Http\Controllers;

use App\Models\Tb_impuesto;
use Illuminate\Http\Request;

class Tb_impuestoController extends Controller
{
    public function index(Request $request)
    {
        $impuesto = Tb_impuesto::orderBy('tb_impuesto.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'impuesto' => $impuesto
        ];
    }

    public function indexOne(Request $request)
    {
        $impuesto = Tb_impuesto::orderBy('tb_impuesto.id','desc')
        ->where('tb_impuesto.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'impuesto' => $impuesto
        ];
    }

    public function indexPropio(Request $request)
    {
        $impuesto = Tb_impuesto::orderBy('tb_impuesto.id','asc')
        ->where('tb_impuesto.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'impuesto' => $impuesto
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_impuesto=new Tb_impuesto();
            $tb_impuesto->idExterno=$request->idExterno;
            $tb_impuesto->impuesto=$request->impuesto;
            $tb_impuesto->porcentaje=$request->porcentaje;
            $tb_impuesto->estado=1;

            if ($tb_impuesto->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'impuesto creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'impuesto no pudo ser creada'
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
            $tb_impuesto=Tb_impuesto::findOrFail($request->id);
            $tb_impuesto->impuesto=$request->impuesto;
            $tb_impuesto->porcentaje=$request->porcentaje;
            $tb_impuesto->estado=1;

            if ($tb_impuesto->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'impuesto actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'impuesto no pudo ser actualizada'
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
            $tb_impuesto=Tb_impuesto::findOrFail($request->id);
            $tb_impuesto->estado='0';

            if ($tb_impuesto->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'impuesto desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'impuesto no pudo ser desactivada'
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
            $tb_impuesto=Tb_impuesto::findOrFail($request->id);
            $tb_impuesto->estado='1';

            if ($tb_impuesto->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'impuesto activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'impuesto no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
