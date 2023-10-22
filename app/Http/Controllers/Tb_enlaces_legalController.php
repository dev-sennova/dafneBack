<?php

namespace App\Http\Controllers;

use App\Models\Tb_enlaces_legal;
use Illuminate\Http\Request;

class Tb_enlaces_legalController extends Controller
{
    public function index(Request $request)
    {
        $enlaces = Tb_enlaces_legal::orderBy('enlaces','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'enlaces' => $enlaces
        ];
    }

    public function indexOne(Request $request)
    {
        $enlaces = Tb_enlaces_legal::orderBy('enlaces','desc')
        ->where('tb_enlaces_legal.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'enlaces' => $enlaces
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_enlaces_legal=new Tb_enlaces_legal();
            $tb_enlaces_legal->enunciado=$request->enunciado;
            $tb_enlaces_legal->estado=1;

            if ($tb_enlaces_legal->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'enlaces creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'enlaces no pudo ser creada'
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
            $tb_enlaces_legal=Tb_enlaces_legal::findOrFail($request->id);
            $tb_enlaces_legal->enunciado=$request->enunciado;
            $tb_enlaces_legal->estado='1';

            if ($tb_enlaces_legal->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'enlaces actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'enlaces no pudo ser actualizada'
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
            $tb_enlaces_legal=Tb_enlaces_legal::findOrFail($request->id);
            $tb_enlaces_legal->estado='0';

            if ($tb_enlaces_legal->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'enlaces desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'enlaces no pudo ser desactivada'
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
            $tb_enlaces_legal=Tb_enlaces_legal::findOrFail($request->id);
            $tb_enlaces_legal->estado='1';

            if ($tb_enlaces_legal->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'enlaces activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'enlaces no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}

