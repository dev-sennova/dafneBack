<?php

use App\Models\Tb_preguntas_financiera;
use Illuminate\Database\Seeder;

class Tb_preguntas_financieraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_preguntas_financiera.json'));
        foreach ($data as $item){
            Tb_preguntas_financiera::create(array(
                'id' => $item->id,
                'pregunta' => $item->pregunta
            ));
            }
    }
}
