<?php

namespace App\Http\Controllers;

use App\Models\Tb_avances_legal;
use Illuminate\Http\Request;

class Tb_avances_legalController extends Controller
{
    public function index(Request $request)
    {
        $avances_legal = Tb_avances_legal::orderBy('tb_avances_legal.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'avances_legal' => $avances_legal
        ];
    }

    public function indexOne(Request $request)
    {
        $avances_legal = Tb_avances_legal::orderBy('tb_avances_legal.id','desc')
        ->where('tb_avances_legal.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'avances_legal' => $avances_legal
        ];
    }

    public function indexPropio(Request $request)
    {
        $avances_legal = Tb_avances_legal::orderBy('tb_avances_legal.id','asc')
        ->where('tb_avances_legal.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'avances_legal' => $avances_legal
        ];
    }

    public function indexResumen(Request $request)
    {
        $avances_legal = Tb_avances_legal::orderBy('tb_avances_legal.id','asc')
        ->where('tb_avances_legal.idUsuario','=',$request->id)
        ->where('tb_avances_legal.enunciado','=',1)
        ->select('tb_avances_legal.cadena')
        ->get();

        return [
            'estado' => 'Ok',
            'avances_legal' => $avances_legal
        ];
    }

    public function resetLegal(Request $request)
    {
        if($reset_legal=Tb_avances_legal::where('tb_avances_legal.idUsuario',$request->idUsuario)->delete()){
            return [
                'estado' => 'Ok',
                'reset_legal' => "Módulo reseteado con éxito"
            ];
        }else{
            return [
                'estado' => 'Error',
                'reset_legal' => "Falló el reseteo del módulo"
            ];
        }
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_avances_legal=new Tb_avances_legal();
            $tb_avances_legal->idExterno=$request->idExterno;
            $tb_avances_legal->cadena=$request->cadena;
            $tb_avances_legal->pregunta=$request->pregunta;
            $tb_avances_legal->enunciado=$request->enunciado;
            $tb_avances_legal->enlace=$request->enlace;
            $tb_avances_legal->next=$request->next;
            $tb_avances_legal->idUsuario=$request->idUsuario;
            $tb_avances_legal->estado=1;

            if ($tb_avances_legal->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'avances_legal creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'avances_legal no pudo ser creada'
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
            $tb_avances_legal=Tb_avances_legal::findOrFail($request->id);
            $tb_avances_legal->cadena=$request->cadena;
            $tb_avances_legal->pregunta=$request->pregunta;
            $tb_avances_legal->enunciado=$request->enunciado;
            $tb_avances_legal->enlace=$request->enlace;
            $tb_avances_legal->next=$request->next;
            $tb_avances_legal->idUsuario=$request->idUsuario;
            $tb_avances_legal->estado='1';

            if ($tb_avances_legal->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'avances_legal actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'avances_legal no pudo ser actualizada'
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
            $tb_avances_legal=Tb_avances_legal::findOrFail($request->id);
            $tb_avances_legal->estado='0';

            if ($tb_avances_legal->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'avances_legal desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'avances_legal no pudo ser desactivada'
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
            $tb_avances_legal=Tb_avances_legal::findOrFail($request->id);
            $tb_avances_legal->estado='1';

            if ($tb_avances_legal->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'avances_legal activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'avances_legal no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

    public function validarPersona(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        $persona_natural = Tb_avances_legal::where('tb_avances_legal.idUsuario','=',$request->id)
        ->where('tb_avances_legal.enunciado','=',1)
        ->where('tb_avances_legal.idExterno','=',8)
        ->count();

        return [
            'estado' => 'Ok',
            'persona_natural' => $persona_natural
        ];
    }
}
