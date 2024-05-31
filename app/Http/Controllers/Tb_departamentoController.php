<?php

namespace App\Http\Controllers;

use App\Models\Tb_departamento;
use Illuminate\Http\Request;

class Tb_departamentoController extends Controller
{
    public function index(Request $request)
    {
        $departamentos = Tb_departamento::orderBy('nombre', 'asc')->get();

        return [
            'estado' => 'Ok',
            'departamentos' => $departamentos
        ];
    }

    public function indexOne(Request $request)
    {
        $departamento = Tb_departamento::where('id', '=', $request->id)->first();

        return [
            'estado' => 'Ok',
            'departamento' => $departamento
        ];
    }

    public function store(Request $request)
    {
        // if(!$request->ajax()) return redirect('/');

        try {
            $tb_departamento = new Tb_departamento();
            $tb_departamento->nombre = $request->nombre;
            $tb_departamento->estado = 1;

            if ($tb_departamento->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Departamento creado con éxito'
                ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Departamento no pudo ser creado'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }
    }

    public function update(Request $request)
    {
        // if(!$request->ajax()) return redirect('/');

        try {
            $tb_departamento = Tb_departamento::findOrFail($request->id);
            $tb_departamento->nombre = $request->nombre;
            $tb_departamento->estado = 1;

            if ($tb_departamento->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Departamento actualizado con éxito'
                ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Departamento no pudo ser actualizado'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }
    }

    public function deactivate(Request $request)
    {
        // if(!$request->ajax()) return redirect('/');

        try {
            $tb_departamento = Tb_departamento::findOrFail($request->id);
            $tb_departamento->estado = 0;

            if ($tb_departamento->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Departamento desactivado con éxito'
                ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Departamento no pudo ser desactivado'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }
    }

    public function activate(Request $request)
    {
        // if(!$request->ajax()) return redirect('/');

        try {
            $tb_departamento = Tb_departamento::findOrFail($request->id);
            $tb_departamento->estado = 1;

            if ($tb_departamento->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Departamento activado con éxito'
                ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Departamento no pudo ser activado'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }
    }
}
