<?php

use App\Models\Tb_ciudad;
use Illuminate\Database\Seeder;

class Tb_ciudadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_ciudad.json'));
        foreach ($data as $item){
            Tb_ciudad::create(array(
                'id' => $item->id,
                'ciudad' => $item->ciudad,
                'estado' => $item->estado,
            ));
            }
        /*
        DB::table('tb_rol')->insert([
            'rol' => 'SuperAdministrador',
        ]);

        DB::table('tb_rol')->insert([
            'rol' => 'Empresario',
        ]
        );
        */
    }
}
