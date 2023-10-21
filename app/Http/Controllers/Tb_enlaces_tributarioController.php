<?php

namespace App\Http\Controllers;

use App\Models\Tb_enlaces_tributario;
use Illuminate\Http\Request;

class Tb_enlaces_tributarioController extends Controller
{
    public function index(Request $request)
    {
        $enunciados = Tb_enlaces_tributario::orderBy('enunciados','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'enunciados' => $enunciados
        ];
    }

    public function indexOne(Request $request)
    {
        $enunciados = Tb_enlaces_tributario::orderBy('enunciados','desc')
        ->where('tb_enlaces_tributario.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'enunciados' => $enunciados
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_enlaces_tributario=new Tb_enlaces_tributario();
            $tb_enlaces_tributario->enunciado=$request->enunciado;
            $tb_enlaces_tributario->estado=1;

            if ($tb_enlaces_tributario->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'enunciados creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'enunciados no pudo ser creada'
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
            $tb_enlaces_tributario=Tb_enlaces_tributario::findOrFail($request->id);
            $tb_enlaces_tributario->enunciado=$request->enunciado;
            $tb_enlaces_tributario->estado='1';

            if ($tb_enlaces_tributario->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'enunciados actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'enunciados no pudo ser actualizada'
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
            $tb_enlaces_tributario=Tb_enlaces_tributario::findOrFail($request->id);
            $tb_enlaces_tributario->estado='0';

            if ($tb_enlaces_tributario->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'enunciados desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'enunciados no pudo ser desactivada'
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
            $tb_enlaces_tributario=Tb_enlaces_tributario::findOrFail($request->id);
            $tb_enlaces_tributario->estado='1';

            if ($tb_enlaces_tributario->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'enunciados activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'enunciados no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
