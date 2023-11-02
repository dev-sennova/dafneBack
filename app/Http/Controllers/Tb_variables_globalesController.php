<?php

namespace App\Http\Controllers;

use App\Models\Tb_variables_globales;
use Illuminate\Http\Request;

class Tb_variables_globalesController extends Controller
{
    public function index(Request $request)
    {
        $variables_globales = Tb_variables_globales::orderBy('tb_variables_globales.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'variables_globales' => $variables_globales
        ];
    }

    public function indexOne(Request $request)
    {
        $variables_globales = Tb_variables_globales::orderBy('tb_variables_globales.id','desc')
        ->where('tb_variables_globales.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'variables_globales' => $variables_globales
        ];
    }

    public function indexPropio(Request $request)
    {
        $variables_globales = Tb_variables_globales::orderBy('tb_variables_globales.id','asc')
        ->where('tb_variables_globales.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'variables_globales' => $variables_globales
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_variables_globales=new Tb_variables_globales();
            $tb_variables_globales->idExterno=$request->idExterno;
            $tb_variables_globales->variable=$request->variable;
            $tb_variables_globales->valor=$request->valor;
            $tb_variables_globales->estado=1;

            if ($tb_variables_globales->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'variables globales creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'variables globales no pudo ser creada'
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
            $tb_variables_globales=Tb_variables_globales::findOrFail($request->id);
            $tb_variables_globales->variable=$request->variable;
            $tb_variables_globales->valor=$request->valor;
            $tb_variables_globales->estado=1;

            if ($tb_variables_globales->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'variables globales actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'variables globales no pudo ser actualizada'
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
            $tb_variables_globales=Tb_variables_globales::findOrFail($request->id);
            $tb_variables_globales->estado='0';

            if ($tb_variables_globales->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'variables globales desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'variables globales no pudo ser desactivada'
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
            $tb_variables_globales=Tb_variables_globales::findOrFail($request->id);
            $tb_variables_globales->estado='1';

            if ($tb_variables_globales->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'variables globales activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'variables globales no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
