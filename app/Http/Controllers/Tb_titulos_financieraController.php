<?php

namespace App\Http\Controllers;

use App\Models\Tb_titulos_financiera;
use Illuminate\Http\Request;

class Tb_titulos_financieraController extends Controller
{
    public function index(Request $request)
    {
        $titulos = Tb_titulos_financiera::orderBy('titulos','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'titulos' => $titulos
        ];
    }

    public function indexOne(Request $request)
    {
        $titulos = Tb_titulos_financiera::orderBy('titulos','desc')
        ->where('tb_titulos_financiera.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'titulos' => $titulos
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_titulos_financiera=new Tb_titulos_financiera();
            $tb_titulos_financiera->titulo=$request->titulo;
            $tb_titulos_financiera->estado=1;

            if ($tb_titulos_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'titulos creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'titulos no pudo ser creada'
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
            $tb_titulos_financiera=Tb_titulos_financiera::findOrFail($request->id);
            $tb_titulos_financiera->titulo=$request->titulo;
            $tb_titulos_financiera->estado='1';

            if ($tb_titulos_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'titulos actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'titulos no pudo ser actualizada'
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
            $tb_titulos_financiera=Tb_titulos_financiera::findOrFail($request->id);
            $tb_titulos_financiera->estado='0';

            if ($tb_titulos_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'titulos desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'titulos no pudo ser desactivada'
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
            $tb_titulos_financiera=Tb_titulos_financiera::findOrFail($request->id);
            $tb_titulos_financiera->estado='1';

            if ($tb_titulos_financiera->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'titulos activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'titulos no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
