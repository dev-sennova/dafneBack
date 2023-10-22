<?php

use App\Models\Tb_preguntas_legal;
use Illuminate\Database\Seeder;

class Tb_preguntas_legalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_preguntas_legal.json'));
        foreach ($data as $item){
            Tb_preguntas_legal::create(array(
                'id' => $item->id,
                'pregunta' => $item->pregunta
            ));
            }
    }
}
