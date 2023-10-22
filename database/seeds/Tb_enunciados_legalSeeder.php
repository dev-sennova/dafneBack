<?php

use App\Models\Tb_enunciados_legal;
use Illuminate\Database\Seeder;

class Tb_enunciados_legalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_enunciados_legal.json'));
        foreach ($data as $item){
            Tb_enunciados_legal::create(array(
                'id' => $item->id,
                'enunciado' => $item->enunciado
            ));
            }
    }
}
