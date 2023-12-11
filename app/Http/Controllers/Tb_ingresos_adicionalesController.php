<?php

namespace App\Http\Controllers;

use App\Models\Tb_ingresos_adicionales;
use Illuminate\Http\Request;

class Tb_ingresos_adicionalesController extends Controller
{
    public function index(Request $request)
    {
        $ingresos_adicionales = Tb_ingresos_adicionales::orderBy('tb_ingresos_adicionales.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'ingresos_adicionales' => $ingresos_adicionales
        ];
    }

    public function indexOne(Request $request)
    {
        $ingresos_adicionales = Tb_ingresos_adicionales::orderBy('tb_ingresos_adicionales.id','desc')
        ->where('tb_ingresos_adicionales.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'ingresos_adicionales' => $ingresos_adicionales
        ];
    }

    public function indexPropio(Request $request)
    {
        $ingresos_adicionales = Tb_ingresos_adicionales::orderBy('tb_ingresos_adicionales.id','asc')
        ->where('tb_ingresos_adicionales.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'ingresos_adicionales' => $ingresos_adicionales
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_ingresos_adicionales=new Tb_ingresos_adicionales();
            $tb_ingresos_adicionales->concepto=$request->concepto;
            $tb_ingresos_adicionales->valor=$request->valor;
            $tb_ingresos_adicionales->idUsuario=$request->idUsuario;
            $tb_ingresos_adicionales->estado=1;

            if ($tb_ingresos_adicionales->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'ingresos_adicionales creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'ingresos_adicionales no pudo ser creada'
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
            $tb_ingresos_adicionales=Tb_ingresos_adicionales::findOrFail($request->id);
            $tb_ingresos_adicionales->concepto=$request->concepto;
            $tb_ingresos_adicionales->valor=$request->valor;
            $tb_ingresos_adicionales->idUsuario=$request->idUsuario;
            $tb_ingresos_adicionales->estado=1;

            if ($tb_ingresos_adicionales->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'ingresos_adicionales actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'ingresos_adicionales no pudo ser actualizada'
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
            $tb_ingresos_adicionales=Tb_ingresos_adicionales::findOrFail($request->id);
            $tb_ingresos_adicionales->estado='0';

            if ($tb_ingresos_adicionales->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'ingresos_adicionales desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'ingresos_adicionales no pudo ser desactivada'
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
            $tb_ingresos_adicionales=Tb_ingresos_adicionales::findOrFail($request->id);
            $tb_ingresos_adicionales->estado='1';

            if ($tb_ingresos_adicionales->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'ingresos_adicionales activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'ingresos_adicionales no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
