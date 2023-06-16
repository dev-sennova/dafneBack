<?php

namespace App\Http\Controllers;

use App\Models\Tb_ideas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_ideasController extends Controller
{
    public function index(Request $request)
    {
        $ideas = Tb_ideas::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'ideas' => $ideas
        ];
    }

    public function indexOne(Request $request)
    {
        $ideas = Tb_ideas::orderBy('id','desc')
        ->where('tb_ideas.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'ideas' => $ideas
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_ideas=new Tb_ideas();
            $tb_ideas->ideas=$request->ideas;
            $tb_ideas->visibilidad=$request->visibilidad;
            $tb_ideas->estado=1;

            if ($tb_ideas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Ideas creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Ideas no pudo ser creado'
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
            $tb_ideas=Tb_ideas::findOrFail($request->id);
            $tb_ideas->ideas=$request->ideas;
            $tb_ideas->visibilidad=$request->visibilidad;

            if ($tb_ideas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Ideas actualizado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Ideas no pudo ser actualizado'
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
            $tb_ideas=Tb_ideas::findOrFail($request->id);
            $tb_ideas->estado='0';

            if ($tb_ideas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Ideas desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Ideas no pudo ser desactivado'
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
            $tb_ideas=Tb_ideas::findOrFail($request->id);
            $tb_ideas->estado='1';

            if ($tb_ideas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Ideas activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Ideas no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
