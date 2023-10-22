<?php

use App\Models\Tb_enlaces_legal;
use Illuminate\Database\Seeder;

class Tb_enlaces_legalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_enlaces_legal.json'));
        foreach ($data as $item){
            Tb_enlaces_legal::create(array(
                'id' => $item->id,
                'enlace' => $item->enlace
            ));
            }
    }
}

