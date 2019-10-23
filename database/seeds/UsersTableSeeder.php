<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $users = [
            [ 'name' => 'Mohamed Aiman', 'email' => 'muhammadhu.aiman@gmail.com', 'password' => bcrypt('password'), 'is_active' => true],
            [ 'name' => 'Test User', 'email' => 'all@gmail.com', 'password' => bcrypt('password'), 'is_active' => true],
            [ 'name' => 'Front Desk User', 'email' => 'front_desk@m.com', 'password' => bcrypt('password'), 'is_active' => true],
            [ 'name' => 'Inspector User', 'email' => 'inspector@m.com', 'password' => bcrypt('password'), 'is_active' => true],
            [ 'name' => 'Supervisor User', 'email' => 'supervisor@m.com', 'password' => bcrypt('password'), 'is_active' => true],
            [ 'name' => 'Head User', 'email' => 'head@m.com', 'password' => bcrypt('password'), 'is_active' => true],
        ];

        $user = new User;

        foreach ($users as $data) {
            $user->create($data);
        }
    }
}
