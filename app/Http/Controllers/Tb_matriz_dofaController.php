<?php

namespace App\Http\Controllers;

use App\Models\Tb_matriz_dofa;
use Illuminate\Http\Request;

class Tb_matriz_dofaController extends Controller
{
    public function index(Request $request)
    {
        $matriz_dofa = Tb_matriz_dofa::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'matriz_dofa' => $matriz_dofa
        ];
    }

    public function indexOne(Request $request)
    {
        $matriz_dofa = Tb_matriz_dofa::orderBy('id','desc')
        ->where('tb_matriz_dofa.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'matriz_dofa' => $matriz_dofa
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_matriz_dofa=new Tb_matriz_dofa();
            $tb_matriz_dofa->debilidades=$request->debilidades;
            $tb_matriz_dofa->oportunidades=$request->oportunidades;
            $tb_matriz_dofa->fortalezas=$request->fortalezas;
            $tb_matriz_dofa->amenazas=$request->amenazas;
            $tb_matriz_dofa->avanced=$request->avanced;
            $tb_matriz_dofa->avanceo=$request->avanceo;
            $tb_matriz_dofa->avancef=$request->avancef;
            $tb_matriz_dofa->avancea=$request->avancea;
            $tb_matriz_dofa->estado='1';
            $tb_matriz_dofa->idUsuario=$request->idUsuario;

            if ($tb_matriz_dofa->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Matriz dofa creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Matriz dofa no pudo ser creada'
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
            $tb_matriz_dofa=Tb_matriz_dofa::findOrFail($request->id);
            $tb_matriz_dofa->debilidades=$request->debilidades;
            $tb_matriz_dofa->oportunidades=$request->oportunidades;
            $tb_matriz_dofa->fortalezas=$request->fortalezas;
            $tb_matriz_dofa->amenazas=$request->amenazas;
            $tb_matriz_dofa->avanced=$request->avanced;
            $tb_matriz_dofa->avanceo=$request->avanceo;
            $tb_matriz_dofa->avancef=$request->avancef;
            $tb_matriz_dofa->avancea=$request->avancea;
            $tb_matriz_dofa->estado='1';
            $tb_matriz_dofa->idUsuario=$request->idUsuario;

            if ($tb_matriz_dofa->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Matriz dofa actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Matriz dofa no pudo ser actualizada'
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
            $tb_matriz_dofa=Tb_matriz_dofa::findOrFail($request->id);
            $tb_matriz_dofa->estado='0';

            if ($tb_matriz_dofa->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Matriz dofa desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Matriz dofa no pudo ser desactivada'
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
            $tb_matriz_dofa=Tb_matriz_dofa::findOrFail($request->id);
            $tb_matriz_dofa->estado='1';

            if ($tb_matriz_dofa->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Matriz dofa activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Matriz dofa no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
