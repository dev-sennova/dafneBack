<?php

use App\Models\Tb_enlaces_tributario;
use Illuminate\Database\Seeder;

class Tb_enlaces_tributarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_enlaces_tributario.json'));
        foreach ($data as $item){
            Tb_enlaces_tributario::create(array(
                'id' => $item->id,
                'enlace' => $item->enlace
            ));
            }
    }
}
