<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = 'Theizer';
        $user->last_name = 'Gonzalez';
        $user->username = 'admin';
        $user->email = 'admin@mail.com';
        $user->password = 'admin';
        $user->status = 1; // (1) active (0)disabled
        $user->direccion = 'San Agustin del Sur';
        $user->fecha_nacimiento = '18/05/1994';
        $user->nacionalidad_id = 1;
        $user->genero_id = 1;
        $user->save();

        $user->assignRole('Administrador');

    }
}
