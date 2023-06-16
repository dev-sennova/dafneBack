<?php

namespace App\Http\Controllers;

use App\Models\Tb_suenos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_suenosController extends Controller
{
    public function index(Request $request)
    {
        $suenos = Tb_suenos::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'suenos' => $suenos
        ];
    }

    public function indexOne(Request $request)
    {
        $suenos = Tb_suenos::orderBy('id','desc')
        ->where('tb_suenos.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'suenos' => $suenos
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_suenos=new Tb_suenos();
            $tb_suenos->suenos=$request->suenos;
            $tb_suenos->visibilidad=$request->visibilidad;
            $tb_suenos->moderacion=$request->moderacion;
            $tb_suenos->estado=1;

            if ($tb_suenos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Sueños creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Sueños no pudo ser creado'
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
            $tb_suenos=Tb_suenos::findOrFail($request->id);
            $tb_suenos->suenos=$request->suenos;
            $tb_suenos->visibilidad=$request->visibilidad;
            $tb_suenos->moderacion=$request->moderacion;
            $tb_suenos->estado='1';

            if ($tb_suenos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Sueños actualizado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Sueños no pudo ser actualizado'
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
            $tb_suenos=Tb_suenos::findOrFail($request->id);
            $tb_suenos->estado='0';

            if ($tb_suenos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Sueños desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Sueños no pudo ser desactivado'
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
            $tb_suenos=Tb_suenos::findOrFail($request->id);
            $tb_suenos->estado='1';

            if ($tb_suenos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Sueños activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Sueños no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
