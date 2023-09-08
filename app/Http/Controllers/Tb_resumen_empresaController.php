<?php

namespace App\Http\Controllers;
use App\Models\Tb_resumen_empresa;
use Illuminate\Http\Request;

class Tb_resumen_empresaController extends Controller
{
    public function index(Request $request)
    {
        $resumen_empresa = Tb_resumen_empresa::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'resumen_empresa' => $resumen_empresa
        ];
    }

    public function indexOne(Request $request)
    {
        $resumen_empresa = Tb_resumen_empresa::orderBy('id','desc')
        ->where('tb_resumen_empresa.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'resumen_empresa' => $resumen_empresa
        ];
    }

    public function indexByUser(Request $request)
    {
        $resumen_empresa = Tb_resumen_empresa::orderBy('id','desc')
        ->where('tb_resumen_empresa.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'resumen_empresa' => $resumen_empresa
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $resumen_empresa=new Tb_resumen_empresa();
            $resumen_empresa->nombreIdea=$request->nombreIdea;
            $resumen_empresa->idUsuario=$request->idUsuario;
            $resumen_empresa->nombreEmpresa=$request->nombreEmpresa;
            $resumen_empresa->mision=$request->mision;
            $resumen_empresa->vision=$request->vision;
            $resumen_empresa->slogan=$request->slogan;
            $resumen_empresa->logo=$request->logo;
            $resumen_empresa->estado=1;

            if ($resumen_empresa->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Resumen empresa creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Resumen empresa no pudo ser creado'
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
            $resumen_empresa=Tb_resumen_empresa::findOrFail($request->id);
            $resumen_empresa->nombreIdea=$request->nombreIdea;
            $resumen_empresa->idUsuario=$request->idUsuario;
            $resumen_empresa->nombreEmpresa=$request->nombreEmpresa;
            $resumen_empresa->mision=$request->mision;
            $resumen_empresa->vision=$request->vision;
            $resumen_empresa->slogan=$request->slogan;
            $resumen_empresa->logo=$request->logo;
            $resumen_empresa->estado=1;

            if ($resumen_empresa->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Resumen empresa actualizado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Resumen empresa no pudo ser actualizado'
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
            $resumen_empresa=Tb_resumen_empresa::findOrFail($request->id);
            $resumen_empresa->estado='0';

            if ($resumen_empresa->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Resumen empresa desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Resumen empresa no pudo ser desactivado'
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
            $resumen_empresa=Tb_resumen_empresa::findOrFail($request->id);
            $resumen_empresa->estado='1';

            if ($resumen_empresa->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Resumen empresa activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Resumen empresa no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
