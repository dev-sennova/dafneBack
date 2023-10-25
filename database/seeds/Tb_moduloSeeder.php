<?php

use App\Models\Tb_modulo;
use Illuminate\Database\Seeder;

class Tb_moduloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_modulo.json'));
        foreach ($data as $item){
            Tb_modulo::create(array(
                'id' => $item->id,
                'modulo' => $item->modulo
            ));
            }
    }
}
