<?php

namespace App\Http\Controllers;

use App\Models\Tb_hobbies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_hobbiesController extends Controller
{
    public function index(Request $request)
    {
        $hobbies = Tb_hobbies::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'hobbies' => $hobbies
        ];
    }

    public function indexOne(Request $request)
    {
        $hobbies = Tb_hobbies::orderBy('id','desc')
        ->where('tb_hobbies.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'hobbies' => $hobbies
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_hobbies=new Tb_hobbies();
            $tb_hobbies->hobby=$request->hobby;
            $tb_hobbies->visibilidad=$request->visibilidad;
            $tb_hobbies->moderacion=$request->moderacion;
            $tb_hobbies->estado=1;

            if ($tb_hobbies->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Hobbies creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Hobbies no pudo ser creado'
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
            $tb_hobbies=Tb_hobbies::findOrFail($request->id);
            $tb_hobbies->hobby=$request->hobby;
            $tb_hobbies->visibilidad=$request->visibilidad;
            $tb_hobbies->moderacion=$request->moderacion;
            $tb_hobbies->estado='1';

            if ($tb_hobbies->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Hobbies actualizado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Hobbies no pudo ser actualizado'
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
            $tb_hobbies=Tb_hobbies::findOrFail($request->id);
            $tb_hobbies->estado='0';

            if ($tb_hobbies->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Hobbies desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Hobbies no pudo ser desactivado'
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
            $tb_hobbies=Tb_hobbies::findOrFail($request->id);
            $tb_hobbies->estado='1';

            if ($tb_hobbies->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Hobbies activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Hobbies no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
