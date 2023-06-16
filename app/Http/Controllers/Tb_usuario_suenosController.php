<?php

namespace App\Http\Controllers;

use App\Models\Tb_usuario_suenos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_usuario_suenos_suenosController extends Controller
{
    public function index(Request $request)
    {
        $usuario_suenos = Tb_usuario_suenos::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'usuario_suenos' => $usuario_suenos
        ];
    }

    public function indexOne(Request $request)
    {
        $usuario_suenos = Tb_usuario_suenos::orderBy('id','desc')
        ->where('tb_usuario_suenos.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'usuario_suenos' => $usuario_suenos
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_usuario_suenos=new Tb_usuario_suenos();
            $tb_usuario_suenos->prioridad=$request->prioridad;
            $tb_usuario_suenos->idUsuario=$request->idUsuario;
            $tb_usuario_suenos->idSuenos=$request->idSuenos;

            if ($tb_usuario_suenos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Usuario Sueños creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario Sueños no pudo ser creado'
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
            $tb_usuario_suenos=Tb_usuario_suenos::findOrFail($request->id);
            $tb_usuario_suenos->prioridad=$request->prioridad;
            $tb_usuario_suenos->idUsuario=$request->idUsuario;
            $tb_usuario_suenos->idSuenos=$request->idSuenos;

            if ($tb_usuario_suenos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Usuario Sueños actualizado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario Sueños no pudo ser actualizado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

}
