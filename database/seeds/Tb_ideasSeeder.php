<?php

use App\Models\Tb_ideas;
use Illuminate\Database\Seeder;

class Tb_ideasSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_ideas.json'));
        foreach ($data as $item){
            Tb_ideas::create(array(
                'id' => $item->id,
                'idea' => $item->idea,
                'visibilidad' => $item->visibilidad,
                'moderacion' => $item->moderacion,
                'estado' => $item->estado,
            ));
            }
    }
}

