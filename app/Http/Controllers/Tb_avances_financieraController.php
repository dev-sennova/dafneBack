<?php

namespace App\Http\Controllers;

use App\Models\Tb_avances_financiera;
use Illuminate\Http\Request;

class Tb_avances_financieraController extends Controller
{
    public function index(Request $request)
    {
        $avances_financiera = Tb_avances_financiera::orderBy('tb_avances_financiera.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'avances_financiera' => $avances_financiera
        ];
    }

    public function indexOne(Request $request)
    {
        $avances_financiera = Tb_avances_financiera::orderBy('tb_avances_financiera.id','desc')
        ->where('tb_avances_financiera.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'avances_financiera' => $avances_financiera
        ];
    }

    public function indexPropio(Request $request)
    {
        $avances_financiera = Tb_avances_financiera::orderBy('tb_avances_financiera.id','asc')
        ->where('tb_avances_financiera.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'avances_financiera' => $avances_financiera
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_avances_financiera=new Tb_avances_financiera();
            $tb_avances_financiera->idExterno=$request->idExterno;
            $tb_avances_financiera->cadena=$request->cadena;
            $tb_avances_financiera->pregunta=$request->pregunta;
            $tb_avances_financiera->enunciado=$request->enunciado;
            $tb_avances_financiera->enlace=$request->enlace;
            $tb_avances_financiera->next=$request->next;
            $tb_avances_financiera->idUsuario=$request->idUsuario;
            $tb_avances_financiera->estado=1;

            if ($tb_avances_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Avances financiera creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Avances financiera no pudo ser creada'
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
            $tb_avances_financiera=Tb_avances_financiera::findOrFail($request->id);
            $tb_avances_financiera->cadena=$request->cadena;
            $tb_avances_financiera->pregunta=$request->pregunta;
            $tb_avances_financiera->enunciado=$request->enunciado;
            $tb_avances_financiera->enlace=$request->enlace;
            $tb_avances_financiera->next=$request->next;
            $tb_avances_financiera->idUsuario=$request->idUsuario;
            $tb_avances_financiera->estado='1';

            if ($tb_avances_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Avances financiera actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Avances financiera no pudo ser actualizada'
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
            $tb_avances_financiera=Tb_avances_financiera::findOrFail($request->id);
            $tb_avances_financiera->estado='0';

            if ($tb_avances_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Avances financiera desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Avances financiera no pudo ser desactivada'
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
            $tb_avances_financiera=Tb_avances_financiera::findOrFail($request->id);
            $tb_avances_financiera->estado='1';

            if ($tb_avances_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Avances financiera activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Avances financiera no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
