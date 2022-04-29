<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        Role::truncate();

        $adminRole = Role::create(['name' => 'Administrador']);
        $supervisorRole = Role::create(['name' => 'Supervisor']);
        $coordiandorRole = Role::create(['name' => 'Coordinador']);

        $admin = New User;
        $admin->dni = '0802704172';
        $admin->first_name = 'Cristhian Andres';
        $admin->last_name = 'Recalde Solanno';
        $admin->phone = '0939242242';
        $admin->email = 'azw1021@gmail.com';
        $admin->password = Hash::make('a123456');
        $admin->user_id = 1;
        $admin->canton_id = 1;
        $admin->parroquia_id = 68;
        $admin->save();
        $admin->assignRole($adminRole);


        $supervisor = New User;
        $supervisor->dni = '0803147090';
        $supervisor->first_name = 'Lino';
        $supervisor->last_name = 'Espinoza';
        $supervisor->phone = '0923456789';
        $supervisor->email = 'linoespinoza@gmail.com';
        $supervisor->password = Hash::make('a123456');
        $supervisor->user_id = 1;
        $supervisor->canton_id = 1;
        $supervisor->parroquia_id = 68;
        $supervisor->save();
        $supervisor->assignRole($supervisorRole);


        $coordinador = New User;
        $coordinador->dni = '0802456782';
        $coordinador->first_name = 'Lady Mercedez';
        $coordinador->last_name = 'Cedeno Plaza';
        $coordinador->phone = '0989342145';
        $coordinador->email = 'ladymercedez@gmail.com';
        $coordinador->password = Hash::make('a123456');
        $coordinador->user_id = 1;
        $coordinador->canton_id = 1;
        $coordinador->parroquia_id = 68;
        $coordinador->save();
        $coordinador->assignRole($coordiandorRole);




    }
}
