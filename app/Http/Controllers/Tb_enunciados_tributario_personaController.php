<?php

namespace App\Http\Controllers;

use App\Models\Tb_enunciados_tributario_persona;
use Illuminate\Http\Request;

class Tb_enunciados_tributario_personaController extends Controller
{
    public function index(Request $request)
    {
        $enunciados = Tb_enunciados_tributario_persona::orderBy('enunciados','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'enunciados' => $enunciados
        ];
    }

    public function indexOne(Request $request)
    {
        $enunciados = Tb_enunciados_tributario_persona::orderBy('enunciados','desc')
        ->where('tb_enunciados_tributario_persona.id','=',$request->id)
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
            $tb_enunciados_tributario_persona=new Tb_enunciados_tributario_persona();
            $tb_enunciados_tributario_persona->enunciado=$request->enunciado;
            $tb_enunciados_tributario_persona->estado=1;

            if ($tb_enunciados_tributario_persona->save()) {
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
            $tb_enunciados_tributario_persona=Tb_enunciados_tributario_persona::findOrFail($request->id);
            $tb_enunciados_tributario_persona->enunciado=$request->enunciado;
            $tb_enunciados_tributario_persona->estado='1';

            if ($tb_enunciados_tributario_persona->save()) {
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
            $tb_enunciados_tributario_persona=Tb_enunciados_tributario_persona::findOrFail($request->id);
            $tb_enunciados_tributario_persona->estado='0';

            if ($tb_enunciados_tributario_persona->save()) {
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
            $tb_enunciados_tributario_persona=Tb_enunciados_tributario_persona::findOrFail($request->id);
            $tb_enunciados_tributario_persona->estado='1';

            if ($tb_enunciados_tributario_persona->save()) {
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
