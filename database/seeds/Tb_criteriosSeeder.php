<?php

use App\Models\Tb_criterios;
use Illuminate\Database\Seeder;

class Tb_criteriosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_criterios.json'));
        foreach ($data as $item){
            Tb_criterios::create(array(
                'id' => $item->id,
                'criterio' => $item->criterio,
                'pregunta' => $item->pregunta,
                'visibilidad' => $item->visibilidad,
                'moderacion' => $item->moderacion,
                'estado' => $item->estado,
            ));
            }
    }
}
