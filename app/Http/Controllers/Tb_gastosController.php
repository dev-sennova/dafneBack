<?php

namespace App\Http\Controllers;

use App\Models\Tb_gastos;
use Illuminate\Http\Request;

class Tb_gastosController extends Controller
{
    public function index(Request $request)
    {
        $gastos = Tb_gastos::orderBy('tb_gastos.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'gastos' => $gastos
        ];
    }

    public function indexOne(Request $request)
    {
        $gastos = Tb_gastos::orderBy('tb_gastos.id','desc')
        ->where('tb_gastos.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'gastos' => $gastos
        ];
    }

    public function indexPropio(Request $request)
    {
        $gastos = Tb_gastos::orderBy('tb_gastos.id','asc')
        ->where('tb_gastos.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'gastos' => $gastos
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_gastos=new Tb_gastos();
            $tb_gastos->gasto=$request->gasto;
            $tb_gastos->valor=$request->valor;
            $tb_gastos->idUsuario=$request->idUsuario;
            $tb_gastos->estado=1;

            if ($tb_gastos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'gastos creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'gastos no pudo ser creada'
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
            $tb_gastos=Tb_gastos::findOrFail($request->id);
            $tb_gastos->gasto=$request->gasto;
            $tb_gastos->valor=$request->valor;
            $tb_gastos->idUsuario=$request->idUsuario;
            $tb_gastos->estado=1;

            if ($tb_gastos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'gastos actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'gastos no pudo ser actualizada'
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
            $tb_gastos=Tb_gastos::findOrFail($request->id);
            $tb_gastos->estado='0';

            if ($tb_gastos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'gastos desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'gastos no pudo ser desactivada'
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
            $tb_gastos=Tb_gastos::findOrFail($request->id);
            $tb_gastos->estado='1';

            if ($tb_gastos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'gastos activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'gastos no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
