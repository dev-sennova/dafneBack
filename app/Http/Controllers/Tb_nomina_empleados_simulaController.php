<?php

namespace App\Http\Controllers;

use App\Models\Tb_nomina_empleados_simula;
use Illuminate\Http\Request;

class Tb_nomina_empleados_simulaController extends Controller
{
    public function index(Request $request)
    {
        $nomina_empleados_simula = Tb_nomina_empleados_simula::orderBy('tb_nomina_empleados_simula.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'nomina_empleados_simula' => $nomina_empleados_simula
        ];
    }

    public function indexOne(Request $request)
    {
        $nomina_empleados_simula = Tb_nomina_empleados_simula::orderBy('tb_nomina_empleados_simula.id','desc')
        ->where('tb_nomina_empleados_simula.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'nomina_empleados_simula' => $nomina_empleados_simula
        ];
    }

    public function indexPropio(Request $request)
    {
        $nomina_empleados_simula = Tb_nomina_empleados_simula::orderBy('tb_nomina_empleados_simula.id','asc')
        ->where('tb_nomina_empleados_simula.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'nomina_empleados_simula' => $nomina_empleados_simula
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_nomina_empleados_simula=new Tb_nomina_empleados_simula();
            $tb_nomina_empleados_simula->perfil=$request->perfil;
            $tb_nomina_empleados_simula->valor=$request->valor;
            $tb_nomina_empleados_simula->auxilio=$request->auxilio;
            $tb_nomina_empleados_simula->salud=$request->salud;
            $tb_nomina_empleados_simula->pension=$request->pension;
            $tb_nomina_empleados_simula->arl=$request->arl;
            $tb_nomina_empleados_simula->caja=$request->caja;
            $tb_nomina_empleados_simula->sena=$request->sena;
            $tb_nomina_empleados_simula->icbf=$request->icbf;
            $tb_nomina_empleados_simula->prima=$request->prima;
            $tb_nomina_empleados_simula->cesantias=$request->cesantias;
            $tb_nomina_empleados_simula->vacaciones=$request->vacaciones;
            $tb_nomina_empleados_simula->intereses=$request->intereses;
            $tb_nomina_empleados_simula->costomensual=$request->costomensual;
            $tb_nomina_empleados_simula->productiva=$request->productiva;
            $tb_nomina_empleados_simula->idUsuario=$request->idUsuario;
            $tb_nomina_empleados_simula->estado=1;

            if ($tb_nomina_empleados_simula->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'nomina empleados simula creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'nomina empleados simula no pudo ser creada'
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
            $tb_nomina_empleados_simula=Tb_nomina_empleados_simula::findOrFail($request->id);
            $tb_nomina_empleados_simula->perfil=$request->perfil;
            $tb_nomina_empleados_simula->valor=$request->valor;
            $tb_nomina_empleados_simula->auxilio=$request->auxilio;
            $tb_nomina_empleados_simula->salud=$request->salud;
            $tb_nomina_empleados_simula->pension=$request->pension;
            $tb_nomina_empleados_simula->arl=$request->arl;
            $tb_nomina_empleados_simula->caja=$request->caja;
            $tb_nomina_empleados_simula->sena=$request->sena;
            $tb_nomina_empleados_simula->icbf=$request->icbf;
            $tb_nomina_empleados_simula->prima=$request->prima;
            $tb_nomina_empleados_simula->cesantias=$request->cesantias;
            $tb_nomina_empleados_simula->vacaciones=$request->vacaciones;
            $tb_nomina_empleados_simula->intereses=$request->intereses;
            $tb_nomina_empleados_simula->costomensual=$request->costomensual;
            $tb_nomina_empleados_simula->productiva=$request->productiva;
            $tb_nomina_empleados_simula->idUsuario=$request->idUsuario;
            $tb_nomina_empleados_simula->estado=1;

            if ($tb_nomina_empleados_simula->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'nomina empleados simula actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'nomina empleados simula no pudo ser actualizada'
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
            $tb_nomina_empleados_simula=Tb_nomina_empleados_simula::findOrFail($request->id);
            $tb_nomina_empleados_simula->estado='0';

            if ($tb_nomina_empleados_simula->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'nomina empleados simula desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'nomina empleados simula no pudo ser desactivada'
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
            $tb_nomina_empleados_simula=Tb_nomina_empleados_simula::findOrFail($request->id);
            $tb_nomina_empleados_simula->estado='1';

            if ($tb_nomina_empleados_simula->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'nomina empleados simula activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'nomina empleados simula no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
