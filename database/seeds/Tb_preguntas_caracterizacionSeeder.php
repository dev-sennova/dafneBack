<?php

use App\models\Tb_preguntas_caracterizacion;
use Illuminate\Database\Seeder;

class Tb_preguntas_caracterizacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_preguntas_caracterizacion.json'));
        foreach ($data as $item){
            Tb_preguntas_caracterizacion::create(array(
                'id' => $item->id,
                'pregunta' => $item->pregunta
            ));
            }
    }
}
