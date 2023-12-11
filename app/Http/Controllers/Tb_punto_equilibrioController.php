<?php

namespace App\Http\Controllers;

use App\Models\Tb_punto_equilibrio;
use Illuminate\Http\Request;

class Tb_punto_equilibrioController extends Controller
{
    public function index(Request $request)
    {
        $punto_equilibrio = Tb_punto_equilibrio::orderBy('tb_punto_equilibrio.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'punto_equilibrio' => $punto_equilibrio
        ];
    }

    public function indexOne(Request $request)
    {
        $punto_equilibrio = Tb_punto_equilibrio::orderBy('tb_punto_equilibrio.id','desc')
        ->where('tb_punto_equilibrio.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'punto_equilibrio' => $punto_equilibrio
        ];
    }

    public function indexPropio(Request $request)
    {
        $punto_equilibrio = Tb_punto_equilibrio::orderBy('tb_punto_equilibrio.id','asc')
        ->where('tb_punto_equilibrio.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'punto_equilibrio' => $punto_equilibrio
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_punto_equilibrio=new Tb_punto_equilibrio();
            $tb_punto_equilibrio->costosGastos=$request->costosGastos;
            $tb_punto_equilibrio->precioVentaSinIva=$request->precioVentaSinIva;
            $tb_punto_equilibrio->productosInsumos=$request->productosInsumos;
            $tb_punto_equilibrio->idUsuario=$request->idUsuario;
            $tb_punto_equilibrio->estado=1;

            if ($tb_punto_equilibrio->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'punto_equilibrio creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'punto_equilibrio no pudo ser creada'
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
            $tb_punto_equilibrio=Tb_punto_equilibrio::findOrFail($request->id);
            $tb_punto_equilibrio->costosGastos=$request->costosGastos;
            $tb_punto_equilibrio->precioVentaSinIva=$request->precioVentaSinIva;
            $tb_punto_equilibrio->productosInsumos=$request->productosInsumos;
            $tb_punto_equilibrio->idUsuario=$request->idUsuario;
            $tb_punto_equilibrio->estado=1;

            if ($tb_punto_equilibrio->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'punto_equilibrio actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'punto_equilibrio no pudo ser actualizada'
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
            $tb_punto_equilibrio=Tb_punto_equilibrio::findOrFail($request->id);
            $tb_punto_equilibrio->estado='0';

            if ($tb_punto_equilibrio->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'punto_equilibrio desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'punto_equilibrio no pudo ser desactivada'
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
            $tb_punto_equilibrio=Tb_punto_equilibrio::findOrFail($request->id);
            $tb_punto_equilibrio->estado='1';

            if ($tb_punto_equilibrio->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'punto_equilibrio activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'punto_equilibrio no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
