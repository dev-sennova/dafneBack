<?php

namespace App\Http\Controllers;

use App\Models\Tb_suenos;
use App\Models\Tb_usuario_suenos;
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

    public function indexGeneral(Request $request)
    {
        $suenos = Tb_suenos::orderBy('id','asc')
        ->where('tb_suenos.visibilidad','=','1')
        ->where('tb_suenos.moderacion','<','2')
        ->select('tb_suenos.id','tb_suenos.sueno','tb_suenos.moderacion')
        ->get();

        return [
            'estado' => 'Ok',
            'suenos' => $suenos
        ];
    }

    public function indexPropio(Request $request)
    {
        //Modelo::join('tablaqueseune',basicamente un on)
        $suenos = Tb_suenos::join('tb_usuario_suenos','tb_suenos.id','=','tb_usuario_suenos.idSueno')
        ->where('tb_suenos.visibilidad','=','2')
        ->where('tb_suenos.moderacion','<','2')
        ->where('tb_usuario_suenos.idUsuario','=',$request->id)
        ->select('tb_suenos.id','tb_suenos.sueno','tb_suenos.moderacion')
        ->orderBy('tb_suenos.id','asc')
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
            $tb_suenos->sueno=$request->sueno;
            $tb_suenos->visibilidad=2;
            $tb_suenos->moderacion=0;
            $tb_suenos->estado=1;

            if ($tb_suenos->save()) {
                $idSuenoRecienGuardado = $tb_suenos->id;

                $tb_usuario_suenos=new Tb_usuario_suenos();
                $tb_usuario_suenos->prioridad=0;
                $tb_usuario_suenos->idUsuario=$request->idUsuario;
                $tb_usuario_suenos->idSueno=$idSuenoRecienGuardado;
                $tb_usuario_suenos->save();

                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Sueño creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Sueño no pudo ser creado'
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
            $tb_suenos->sueno=$request->sueno;
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
