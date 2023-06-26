<?php

use App\Models\Tb_hobbies;
use Illuminate\Database\Seeder;

class Tb_hobbiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_hobbies.json'));
        foreach ($data as $item){
            Tb_hobbies::create(array(
                'id' => $item->id,
                'hobby' => $item->hobby,
                'visibilidad' => $item->visibilidad,
                'moderacion' => $item->moderacion,
                'estado' => $item->estado,
            ));
            }
    }
}
