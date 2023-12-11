<?php

namespace App\Http\Controllers;

use App\Models\Tb_gastos_adicionales;
use Illuminate\Http\Request;

class Tb_gastos_adicionalesController extends Controller
{
    public function index(Request $request)
    {
        $gastos_adicionales = Tb_gastos_adicionales::orderBy('tb_gastos_adicionales.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'gastos_adicionales' => $gastos_adicionales
        ];
    }

    public function indexOne(Request $request)
    {
        $gastos_adicionales = Tb_gastos_adicionales::orderBy('tb_gastos_adicionales.id','desc')
        ->where('tb_gastos_adicionales.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'gastos_adicionales' => $gastos_adicionales
        ];
    }

    public function indexPropio(Request $request)
    {
        $gastos_adicionales = Tb_gastos_adicionales::orderBy('tb_gastos_adicionales.id','asc')
        ->where('tb_gastos_adicionales.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'gastos_adicionales' => $gastos_adicionales
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_gastos_adicionales=new Tb_gastos_adicionales();
            $tb_gastos_adicionales->concepto=$request->concepto;
            $tb_gastos_adicionales->valor=$request->valor;
            $tb_gastos_adicionales->idUsuario=$request->idUsuario;
            $tb_gastos_adicionales->estado=1;

            if ($tb_gastos_adicionales->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'gastos_adicionales creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'gastos_adicionales no pudo ser creada'
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
            $tb_gastos_adicionales=Tb_gastos_adicionales::findOrFail($request->id);
            $tb_gastos_adicionales->concepto=$request->concepto;
            $tb_gastos_adicionales->valor=$request->valor;
            $tb_gastos_adicionales->idUsuario=$request->idUsuario;
            $tb_gastos_adicionales->estado=1;

            if ($tb_gastos_adicionales->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'gastos_adicionales actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'gastos_adicionales no pudo ser actualizada'
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
            $tb_gastos_adicionales=Tb_gastos_adicionales::findOrFail($request->id);
            $tb_gastos_adicionales->estado='0';

            if ($tb_gastos_adicionales->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'gastos_adicionales desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'gastos_adicionales no pudo ser desactivada'
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
            $tb_gastos_adicionales=Tb_gastos_adicionales::findOrFail($request->id);
            $tb_gastos_adicionales->estado='1';

            if ($tb_gastos_adicionales->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'gastos_adicionales activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'gastos_adicionales no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
