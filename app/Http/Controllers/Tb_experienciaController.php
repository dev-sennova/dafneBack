<?php

namespace App\Http\Controllers;

use App\Models\Tb_experiencia;
use Illuminate\Http\Request;

class Tb_experienciaController extends Controller
{
    public function index(Request $request)
    {
        $experiencia = Tb_experiencia::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'experiencia' => $experiencia
        ];
    }

    public function indexOne(Request $request)
    {
        $experiencia = Tb_experiencia::orderBy('id','desc')
        ->where('tb_experiencia.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'experiencia' => $experiencia
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_experiencia=new Tb_experiencia();
            $tb_experiencia->experiencia=$request->experiencia;
            $tb_experiencia->actividades=$request->actividades;
            $tb_experiencia->area=$request->area;
            $tb_experiencia->idUsuario=$request->idUsuario;
            $tb_experiencia->estado=1;

            if ($tb_experiencia->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Experiencia creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Experiencia no pudo ser creada'
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
            $tb_experiencia=Tb_experiencia::findOrFail($request->id);
            $tb_experiencia->experiencia=$request->experiencia;
            $tb_experiencia->actividades=$request->actividades;
            $tb_experiencia->area=$request->area;
            $tb_experiencia->idUsuario=$request->idUsuario;
            $tb_experiencia->estado=1;

            if ($tb_experiencia->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Experiencia actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Experiencia no pudo ser actualizada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
