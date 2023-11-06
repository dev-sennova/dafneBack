<?php

namespace App\Http\Controllers;

use App\Models\Tb_bitacora;
use Illuminate\Http\Request;

class Tb_bitacoraController extends Controller
{
    public function index(Request $request)
    {
        $bitacora = Tb_bitacora::orderBy('tb_bitacora.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'bitacora' => $bitacora
        ];
    }

    public function indexOne(Request $request)
    {
        $bitacora = Tb_bitacora::orderBy('tb_bitacora.id','desc')
        ->where('tb_bitacora.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'bitacora' => $bitacora
        ];
    }

    public function validarAvance(Request $request)
    {
        //Modelo::join('tablaqueseune',basicamente un on)
        $idModulo=$request->idModulo;
        $idUsuario=$request->idUsuario;
        $seccion = Tb_bitacora::join('tb_secciones','tb_bitacora.idSeccion','=','tb_secciones.id')
        ->where('tb_bitacora.idUsuario','=',$idUsuario)
        ->where('tb_secciones.idModulo','=',$idModulo)
        ->select('tb_bitacora.id as id','tb_bitacora.avance as avance','tb_bitacora.idSeccion as idSeccion','tb_bitacora.idUsuario as idUsuario','tb_secciones.seccion as seccion','tb_secciones.idModulo as idModulo')
        ->orderBy('tb_bitacora.id','desc')
        ->first();

        return [
            'estado' => 'Ok',
            'seccion' => $seccion
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_bitacora=new Tb_bitacora();
            $tb_bitacora->avance=$request->avance;
            $tb_bitacora->idSeccion=$request->idSeccion;
            $tb_bitacora->idUsuario=$request->idUsuario;

            if ($tb_bitacora->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'bitacora creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'bitacora no pudo ser creada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno '+$e], 500);
        }

    }

    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_bitacora=Tb_bitacora::findOrFail($request->id);
            $tb_bitacora->avance=$request->avance;
            $tb_bitacora->idSeccion=$request->idSeccion;
            $tb_bitacora->idUsuario=$request->idUsuario;
            $tb_bitacora->estado='1';

            if ($tb_bitacora->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'bitacora actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'bitacora no pudo ser actualizada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

    public function updateReg(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_bit=Tb_bitacora::where('tb_bitacora.idUsuario','=',$request->idUsuario)
            ->where('tb_bitacora.idSeccion','=',$request->idSeccionP)
            ->get();

            foreach($tb_bit as $vueltaE){
                $idBit = $vueltaE->id;
                }

            $tb_bitacora=Tb_bitacora::findOrFail($idBit);
            $tb_bitacora->avance=$request->avance;
            $tb_bitacora->idSeccion=$request->idSeccion;
            $tb_bitacora->idUsuario=$request->idUsuario;
            $tb_bitacora->estado='1';

            if ($tb_bitacora->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'bitacora actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'bitacora no pudo ser actualizada'
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
            $tb_bitacora=Tb_bitacora::findOrFail($request->id);
            $tb_bitacora->estado='0';

            if ($tb_bitacora->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'bitacora desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'bitacora no pudo ser desactivada'
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
            $tb_bitacora=Tb_bitacora::findOrFail($request->id);
            $tb_bitacora->estado='1';

            if ($tb_bitacora->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'bitacora activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'bitacora no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
