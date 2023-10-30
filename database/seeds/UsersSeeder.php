<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_user.json'));
        foreach ($data as $item){
            User::create(array(
                'id' => $item->id,
                'name' => $item->name,
                'email' => $item->email,
                'rol' => $item->rol,
                'password' => $item->password,
            ));
            }
        /*
        DB::table('User')->insert([
            'rol' => 'SuperAdministrador',
        ]);

        DB::table('User')->insert([
            'rol' => 'Empresario',
        ]
        );
        */
    }
}
