<?php

use App\Models\Tb_variables_globales;
use Illuminate\Database\Seeder;

class Tb_variables_globalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_variables_globales.json'));
        foreach ($data as $item){
            Tb_variables_globales::create(array(
                'id' => $item->id,
                'variable' => $item->variable,
                'valor' => $item->valor,
                'estado' => $item->estado,
            ));
            }
    }
}
