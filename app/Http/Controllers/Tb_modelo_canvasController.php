<?php

namespace App\Http\Controllers;

use App\Models\Tb_modelo_canvas;
use Illuminate\Http\Request;

class Tb_modelo_canvasController extends Controller
{
    public function index(Request $request)
    {
        $modelo_canvas = Tb_modelo_canvas::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'modelo_canvas' => $modelo_canvas
        ];
    }

    public function indexOne(Request $request)
    {
        $modelo_canvas = Tb_modelo_canvas::orderBy('id','desc')
        ->where('tb_modelo_canvas.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'modelo_canvas' => $modelo_canvas
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_modelo_canvas=new Tb_modelo_canvas();
            $tb_modelo_canvas->proposicion="";
            $tb_modelo_canvas->segmento="";
            $tb_modelo_canvas->relaciones="";
            $tb_modelo_canvas->canales="";
            $tb_modelo_canvas->actividades="";
            $tb_modelo_canvas->recursos="";
            $tb_modelo_canvas->aliados="";
            $tb_modelo_canvas->flujos="";
            $tb_modelo_canvas->estructura="";
            $tb_modelo_canvas->avancepro='0';
            $tb_modelo_canvas->avanceseg='0';
            $tb_modelo_canvas->avancerel='0';
            $tb_modelo_canvas->avancecan='0';
            $tb_modelo_canvas->avanceact='0';
            $tb_modelo_canvas->avancerec='0';
            $tb_modelo_canvas->avanceali='0';
            $tb_modelo_canvas->avanceflu='0';
            $tb_modelo_canvas->avanceest='0';
            $tb_modelo_canvas->estado='1';
            $tb_modelo_canvas->idUsuario=$request->idUsuario;


            if ($tb_modelo_canvas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Modelo canvas creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Modelo canvas no pudo ser creado'
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
            $tb_modelo_canvas=Tb_modelo_canvas::findOrFail($request->id);
            $tb_modelo_canvas->proposicion=$request->proposicion;
            $tb_modelo_canvas->segmento=$request->segmento;
            $tb_modelo_canvas->relaciones=$request->relaciones;
            $tb_modelo_canvas->canales=$request->canales;
            $tb_modelo_canvas->actividades=$request->actividades;
            $tb_modelo_canvas->recursos=$request->recursos;
            $tb_modelo_canvas->aliados=$request->aliados;
            $tb_modelo_canvas->flujos=$request->flujos;
            $tb_modelo_canvas->estructura=$request->estructura;
            $tb_modelo_canvas->avancepro=$request->avancepro;
            $tb_modelo_canvas->avanceseg=$request->avanceseg;
            $tb_modelo_canvas->avancerel=$request->avancerel;
            $tb_modelo_canvas->avancecan=$request->avancecan;
            $tb_modelo_canvas->avanceact=$request->avanceact;
            $tb_modelo_canvas->avancerec=$request->avancerec;
            $tb_modelo_canvas->avanceali=$request->avanceali;
            $tb_modelo_canvas->avanceflu=$request->avanceflu;
            $tb_modelo_canvas->avanceest=$request->avanceest;
            $tb_modelo_canvas->estado='1';
            $tb_modelo_canvas->idUsuario=$request->idUsuario;

            if ($tb_modelo_canvas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Modelo canvas actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Modelo canvas no pudo ser actualizada'
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
            $tb_modelo_canvas=Tb_modelo_canvas::findOrFail($request->id);
            $tb_modelo_canvas->estado='0';

            if ($tb_modelo_canvas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Modelo canvas desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Modelo canvas no pudo ser desactivada'
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
            $tb_modelo_canvas=Tb_modelo_canvas::findOrFail($request->id);
            $tb_modelo_canvas->estado='1';

            if ($tb_modelo_canvas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Modelo canvas activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Modelo canvas no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
