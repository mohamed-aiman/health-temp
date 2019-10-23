<?php

use App\Http\Controllers\UserRoleController;
use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UsersRolesTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $userRoles = [
            [ 'email' => 'muhammadhu.aiman@gmail.com', 'roles' => ['all']],
            [ 'email' => 'all@gmail.com', 'roles' => ['all']],
            [ 'email' => 'front_desk@m.com', 'roles' => ['front_desk']],
            [ 'email' => 'inspector@m.com', 'roles' => ['inspector']],
            [ 'email' => 'supervisor@m.com', 'roles' => ['supervisor']],
            [ 'email' => 'head@m.com', 'roles' => ['head']],
        ];

        $userInstance = new User;
        $roleInstance = new Role;
        foreach ($userRoles as $userRole) {
            $user = $userInstance->where('email', $userRole['email'])->first();
            foreach ($userRole['roles'] as $roleSlug) {
                $role = $roleInstance->where('slug', $roleSlug)->first();
                $this->command->getOutput()->writeln("<info>attaching $roleSlug to {$user->email}</info>");
                UserRoleController::addRoleWithPermissions($user,$role);
            }
        }
    }
}
