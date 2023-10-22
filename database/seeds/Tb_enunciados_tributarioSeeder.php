<?php

use App\Models\Tb_enunciados_tributario;
use Illuminate\Database\Seeder;

class Tb_enunciados_tributarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_enunciados_tributario.json'));
        foreach ($data as $item){
            Tb_enunciados_tributario::create(array(
                'id' => $item->id,
                'enunciado' => $item->enunciado
            ));
            }
    }
}
