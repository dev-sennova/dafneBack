<?php

namespace App\Http\Controllers;

use App\Models\Tb_escolaridad;
use Illuminate\Http\Request;

class Tb_escolaridadController extends Controller
{
    public function index(Request $request)
    {
        $escolaridad = Tb_escolaridad::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'escolaridad' => $escolaridad
        ];
    }

    public function indexOne(Request $request)
    {
        $escolaridad = Tb_escolaridad::orderBy('id','desc')
        ->where('tb_escolaridad.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'escolaridad' => $escolaridad
        ];
    }

    public function indexByUser(Request $request)
    {
        $resumen_escolaridad = Tb_escolaridad::orderBy('id','desc')
        ->where('tb_escolaridad.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'resumen_escolaridad' => $resumen_escolaridad
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_escolaridad=new Tb_escolaridad();
            $tb_escolaridad->escolaridad=$request->escolaridad;
            $tb_escolaridad->nivelescolaridad=$request->nivelescolaridad;
            $tb_escolaridad->areaconocimiento=$request->areaconocimiento;
            $tb_escolaridad->idUsuario=$request->idUsuario;
            $tb_escolaridad->estado=1;

            if ($tb_escolaridad->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Escolaridad creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Escolaridad no pudo ser creada'
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
            $tb_escolaridad=Tb_escolaridad::findOrFail($request->id);
            $tb_escolaridad->escolaridad=$request->escolaridad;
            $tb_escolaridad->nivelescolaridad=$request->nivelescolaridad;
            $tb_escolaridad->areaconocimiento=$request->areaconocimiento;
            $tb_escolaridad->idUsuario=$request->idUsuario;
            $tb_escolaridad->estado=1;

            if ($tb_escolaridad->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Escolaridad actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Escolaridad no pudo ser actualizada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
