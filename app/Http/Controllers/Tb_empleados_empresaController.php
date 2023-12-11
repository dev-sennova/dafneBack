<?php

namespace App\Http\Controllers;

use App\Models\Tb_empleados_empresa;
use Illuminate\Http\Request;

class Tb_empleados_empresaController extends Controller
{
    public function index(Request $request)
    {
        $empleados_empresa = Tb_empleados_empresa::orderBy('tb_empleados_empresa.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'empleados_empresa' => $empleados_empresa
        ];
    }

    public function indexOne(Request $request)
    {
        $empleados_empresa = Tb_empleados_empresa::orderBy('tb_empleados_empresa.id','desc')
        ->where('tb_empleados_empresa.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'empleados_empresa' => $empleados_empresa
        ];
    }

    public function indexPropio(Request $request)
    {
        $empleados_empresa = Tb_empleados_empresa::orderBy('tb_empleados_empresa.id','asc')
        ->where('tb_empleados_empresa.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'empleados_empresa' => $empleados_empresa
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_empleados_empresa=new Tb_empleados_empresa();
            $tb_empleados_empresa->empleado=$request->empleado;
            $tb_empleados_empresa->produccion=$request->produccion;
            $tb_empleados_empresa->idRiesgo=$request->idRiesgo;
            $tb_empleados_empresa->idPerfil=$request->idPerfil;
            $tb_empleados_empresa->idUsuario=$request->idUsuario;
            $tb_empleados_empresa->estado=1;

            if ($tb_empleados_empresa->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'empleados empresa creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'empleados empresa no pudo ser creada'
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
            $tb_empleados_empresa=Tb_empleados_empresa::findOrFail($request->id);
            $tb_empleados_empresa->empleado=$request->empleado;
            $tb_empleados_empresa->produccion=$request->produccion;
            $tb_empleados_empresa->idRiesgo=$request->idRiesgo;
            $tb_empleados_empresa->idPerfil=$request->idPerfil;
            $tb_empleados_empresa->idUsuario=$request->idUsuario;
            $tb_empleados_empresa->estado=1;

            if ($tb_empleados_empresa->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'empleados empresa actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'empleados empresa no pudo ser actualizada'
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
            $tb_empleados_empresa=Tb_empleados_empresa::findOrFail($request->id);
            $tb_empleados_empresa->estado='0';

            if ($tb_empleados_empresa->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'empleados empresa desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'empleados empresa no pudo ser desactivada'
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
            $tb_empleados_empresa=Tb_empleados_empresa::findOrFail($request->id);
            $tb_empleados_empresa->estado='1';

            if ($tb_empleados_empresa->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'empleados empresa activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'empleados empresa no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
