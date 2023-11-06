<?php

namespace App\Http\Controllers;

use App\Models\Tb_avances_tributario;
use Illuminate\Http\Request;

class Tb_avances_tributarioController extends Controller
{
    public function index(Request $request)
    {
        $avances_tributario = Tb_avances_tributario::orderBy('tb_avances_tributario.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'avances_tributario' => $avances_tributario
        ];
    }

    public function indexOne(Request $request)
    {
        $avances_tributario = Tb_avances_tributario::orderBy('tb_avances_tributario.id','desc')
        ->where('tb_avances_tributario.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'avances_tributario' => $avances_tributario
        ];
    }

    public function indexResumen(Request $request)
    {
        $avances_tributario = Tb_avances_tributario::orderBy('tb_avances_tributario.id','asc')
        ->where('tb_avances_tributario.idUsuario','=',$request->id)
        ->where('tb_avances_tributario.enunciado','=',1)
        ->select('tb_avances_tributario.cadena')
        ->get();

        return [
            'estado' => 'Ok',
            'avances_tributario' => $avances_tributario
        ];
    }

    public function resetTributarioEmpresa(Request $request)
    {
        if($tb_avances_tributario=Tb_avances_tributario::where('tb_avances_tributario.idUsuario',$request->idUsuario)->delete()){
            return [
                'estado' => 'Ok',
                'reset_tributario_empresa' => "Módulo reseteado con éxito"
            ];
        }else{
            return [
                'estado' => 'Error',
                'reset_tributario_empresa' => "Falló el reseteo del módulo"
            ];
        }
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_avances_tributario=new Tb_avances_tributario();
            $tb_avances_tributario->idExterno=$request->idExterno;
            $tb_avances_tributario->cadena=$request->cadena;
            $tb_avances_tributario->pregunta=$request->pregunta;
            $tb_avances_tributario->enunciado=$request->enunciado;
            $tb_avances_tributario->enlace=$request->enlace;
            $tb_avances_tributario->next=$request->next;
            $tb_avances_tributario->idUsuario=$request->idUsuario;
            $tb_avances_tributario->estado=1;

            if ($tb_avances_tributario->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'avances_tributario creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'avances_tributario no pudo ser creada'
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
            $tb_avances_tributario=Tb_avances_tributario::findOrFail($request->id);
            $tb_avances_tributario->cadena=$request->cadena;
            $tb_avances_tributario->pregunta=$request->pregunta;
            $tb_avances_tributario->enunciado=$request->enunciado;
            $tb_avances_tributario->enlace=$request->enlace;
            $tb_avances_tributario->next=$request->next;
            $tb_avances_tributario->idUsuario=$request->idUsuario;
            $tb_avances_tributario->estado='1';

            if ($tb_avances_tributario->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'avances_tributario actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'avances_tributario no pudo ser actualizada'
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
            $tb_avances_tributario=Tb_avances_tributario::findOrFail($request->id);
            $tb_avances_tributario->estado='0';

            if ($tb_avances_tributario->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'avances_tributario desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'avances_tributario no pudo ser desactivada'
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
            $tb_avances_tributario=Tb_avances_tributario::findOrFail($request->id);
            $tb_avances_tributario->estado='1';

            if ($tb_avances_tributario->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'avances_tributario activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'avances_tributario no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
