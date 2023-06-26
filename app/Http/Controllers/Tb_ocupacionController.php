<?php

namespace App\Http\Controllers;

use App\Models\Tb_ocupacion;
use Illuminate\Http\Request;

class Tb_ocupacionController extends Controller
{
    public function index(Request $request)
    {
        $ocupacion = Tb_ocupacion::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'ocupacion' => $ocupacion
        ];
    }

    public function indexOne(Request $request)
    {
        $ocupacion = Tb_ocupacion::orderBy('id','desc')
        ->where('tb_ocupacion.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'ocupacion' => $ocupacion
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_ocupacion=new Tb_ocupacion();
            $tb_ocupacion->ocupacion=$request->ocupacion;
            $tb_ocupacion->lugar=$request->lugar;
            $tb_ocupacion->area=$request->area;
            $tb_ocupacion->idUsuario=$request->idUsuario;
            $tb_ocupacion->estado=1;

            if ($tb_ocupacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Ocupacion creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Ocupacion no pudo ser creada'
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
            $tb_ocupacion=Tb_ocupacion::findOrFail($request->id);
            $tb_ocupacion->ocupacion=$request->ocupacion;
            $tb_ocupacion->lugar=$request->lugar;
            $tb_ocupacion->area=$request->area;
            $tb_ocupacion->idUsuario=$request->idUsuario;
            $tb_ocupacion->estado=1;

            if ($tb_ocupacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Ocupacion actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Ocupacion no pudo ser actualizada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
