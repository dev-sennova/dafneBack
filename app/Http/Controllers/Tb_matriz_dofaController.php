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
        ->where('tb_matriz_dofa.idUsuario','=',$request->id)
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
            $tb_matriz_dofa->debilidades1="";
            $tb_matriz_dofa->oportunidades1="";
            $tb_matriz_dofa->fortalezas1="";
            $tb_matriz_dofa->amenazas1="";
            $tb_matriz_dofa->debilidades2="";
            $tb_matriz_dofa->oportunidades2="";
            $tb_matriz_dofa->fortalezas2="";
            $tb_matriz_dofa->amenazas2="";
            $tb_matriz_dofa->debilidades3="";
            $tb_matriz_dofa->oportunidades3="";
            $tb_matriz_dofa->fortalezas3="";
            $tb_matriz_dofa->amenazas3="";
            $tb_matriz_dofa->debilidades4="";
            $tb_matriz_dofa->oportunidades4="";
            $tb_matriz_dofa->fortalezas4="";
            $tb_matriz_dofa->amenazas4="";
            $tb_matriz_dofa->avanced='0';
            $tb_matriz_dofa->avanceo='0';
            $tb_matriz_dofa->avancef='0';
            $tb_matriz_dofa->avancea='0';
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
            $tb_matriz_dofa->debilidades1=$request->debilidades1;
            $tb_matriz_dofa->oportunidades1=$request->oportunidades1;
            $tb_matriz_dofa->fortalezas1=$request->fortalezas1;
            $tb_matriz_dofa->amenazas1=$request->amenazas1;
            $tb_matriz_dofa->debilidades2=$request->debilidades2;
            $tb_matriz_dofa->oportunidades2=$request->oportunidades2;
            $tb_matriz_dofa->fortalezas2=$request->fortalezas2;
            $tb_matriz_dofa->amenazas2=$request->amenazas2;
            $tb_matriz_dofa->debilidades3=$request->debilidades3;
            $tb_matriz_dofa->oportunidades3=$request->oportunidades3;
            $tb_matriz_dofa->fortalezas3=$request->fortalezas3;
            $tb_matriz_dofa->amenazas3=$request->amenazas3;
            $tb_matriz_dofa->debilidades4=$request->debilidades4;
            $tb_matriz_dofa->oportunidades4=$request->oportunidades4;
            $tb_matriz_dofa->fortalezas4=$request->fortalezas4;
            $tb_matriz_dofa->amenazas4=$request->amenazas4;
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
            return response()->json(['error' => 'Ocurrió un error interno '.$e], 500);
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
