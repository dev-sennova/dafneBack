<?php

use App\Models\Tb_secciones;
use Illuminate\Database\Seeder;

class Tb_seccionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_secciones.json'));
        foreach ($data as $item){
            Tb_secciones::create(array(
                'id' => $item->id,
                'seccion' => $item->seccion,
                'idModulo' => $item->idModulo,
                'basicos' => $item->basicos,
                'caracterizacion' => $item->caracterizacion,
                'criterios' => $item->criterios,
                'estrategias' => $item->estrategias,
                'evaluacion' => $item->evaluacion,
                'experiencia' => $item->experiencia,
                'hobbies' => $item->hobbies,
                'home' => $item->home,
                'ideas' => $item->ideas,
                'matriz' => $item->matriz,
                'matrizdofa' => $item->matrizdofa,
                'modelocanvas' => $item->modelocanvas,
                'resumen' => $item->resumen,
                'resumenideacion' => $item->resumenideacion,
                'seleccion' => $item->seleccion,
                'suenos' => $item->suenos,
                'valorcriterios' => $item->valorcriterios,
                'valorhobbies' => $item->valorhobbies,
                'valorsuenos' => $item->valorsuenos,
                'vistadofa' => $item->vistadofa
            ));
            }
    }
}
