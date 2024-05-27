<?php

namespace App\Http\Controllers;

use App\Models\Tb_ciudad;
use Illuminate\Http\Request;

class Tb_ciudadController extends Controller
{
    public function index(Request $request)
    {
        $ciudad = Tb_ciudad::orderBy('ciudad','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'ciudad' => $ciudad
        ];
    }

    public function indexOne(Request $request)
    {
        $ciudad = Tb_ciudad::orderBy('ciudad','desc')
        ->where('tb_ciudad.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'ciudad' => $ciudad
        ];
    }

    public function filterByDepartamento(Request $request)
    {
        $ciudades = Tb_ciudad::where('departamento_id', $request->departamento_id)
                             ->orderBy('ciudad', 'asc')
                             ->get();

        return [
            'estado' => 'Ok',
            'ciudades' => $ciudades
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_ciudad=new Tb_ciudad();
            $tb_ciudad->ciudad=$request->ciudad;
            $tb_ciudad->estado=1;

            if ($tb_ciudad->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Ciudad creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Ciudad no pudo ser creada'
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
            $tb_ciudad=Tb_ciudad::findOrFail($request->id);
            $tb_ciudad->ciudad=$request->ciudad;
            $tb_ciudad->estado='1';

            if ($tb_ciudad->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Ciudad actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Ciudad no pudo ser actualizada'
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
            $tb_ciudad=Tb_ciudad::findOrFail($request->id);
            $tb_ciudad->estado='0';

            if ($tb_ciudad->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Ciudad desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Ciudad no pudo ser desactivada'
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
            $tb_ciudad=Tb_ciudad::findOrFail($request->id);
            $tb_ciudad->estado='1';

            if ($tb_ciudad->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Ciudad activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Ciudad no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
