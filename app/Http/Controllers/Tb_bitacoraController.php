<?php

namespace App\Http\Controllers;

use App\Models\Tb_bitacora;
use Illuminate\Http\Request;

class Tb_bitacoraController extends Controller
{
    public function index(Request $request)
    {
        $bitacora = Tb_bitacora::orderBy('bitacora','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'bitacora' => $bitacora
        ];
    }

    public function indexOne(Request $request)
    {
        $bitacora = Tb_bitacora::orderBy('bitacora','desc')
        ->where('tb_bitacora.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'bitacora' => $bitacora
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
            $tb_bitacora->estado=1;

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
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
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
