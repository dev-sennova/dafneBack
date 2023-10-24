<?php

namespace App\Http\Controllers;

use App\Models\Tb_avances_tributario_persona;
use Illuminate\Http\Request;

class Tb_avances_tributario_personaController extends Controller
{
    public function index(Request $request)
    {
        $avances_tributario_persona = Tb_avances_tributario_persona::orderBy('tb_avances_tributario_persona.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'avances_tributario_persona' => $avances_tributario_persona
        ];
    }

    public function indexOne(Request $request)
    {
        $avances_tributario_persona = Tb_avances_tributario_persona::orderBy('tb_avances_tributario_persona.id','desc')
        ->where('tb_avances_tributario_persona.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'avances_tributario_persona' => $avances_tributario_persona
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
            $tb_avances_tributario_persona->idExterno=$request->idExterno;
            $tb_avances_tributario_persona->cadena=$request->cadena;
            $tb_avances_tributario_persona->pregunta=$request->pregunta;
            $tb_avances_tributario_persona->enunciado=$request->enunciado;
            $tb_avances_tributario_persona->enlace=$request->enlace;
            $tb_avances_tributario_persona->idUsuario=$request->idUsuario;
            $tb_avances_tributario_persona->estado=1;

            if ($tb_avances_tributario_persona->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'avances_tributario_persona creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'avances_tributario_persona no pudo ser creada'
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
            $tb_avances_tributario_persona=Tb_avances_tributario_persona::findOrFail($request->id);
            $tb_avances_tributario_persona->cadena=$request->cadena;
            $tb_avances_tributario_persona->pregunta=$request->pregunta;
            $tb_avances_tributario_persona->enunciado=$request->enunciado;
            $tb_avances_tributario_persona->enlace=$request->enlace;
            $tb_avances_tributario_persona->idUsuario=$request->idUsuario;
            $tb_avances_tributario_persona->estado='1';

            if ($tb_avances_tributario_persona->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'avances_tributario_persona actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'avances_tributario_persona no pudo ser actualizada'
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
            $tb_avances_tributario_persona=Tb_avances_tributario_persona::findOrFail($request->id);
            $tb_avances_tributario_persona->estado='0';

            if ($tb_avances_tributario_persona->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'avances_tributario_persona desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'avances_tributario_persona no pudo ser desactivada'
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
            $tb_avances_tributario_persona=Tb_avances_tributario_persona::findOrFail($request->id);
            $tb_avances_tributario_persona->estado='1';

            if ($tb_avances_tributario_persona->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'avances_tributario_persona activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'avances_tributario_persona no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
