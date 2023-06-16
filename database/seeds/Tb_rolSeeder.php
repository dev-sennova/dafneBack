<?php

use Illuminate\Database\Seeder;
use App\Models\Tb_rol;

class Tb_rolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_rol.json'));
        foreach ($data as $item){
            Tb_rol::create(array(
                'id' => $item->id,
                'rol' => $item->rol,
                'rol' => $item->estado,
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
