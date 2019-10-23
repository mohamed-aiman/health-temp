<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class RolesPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->getOutput()->writeln("<info>Attaching all permissions to 'all' role ....</info>");
        $role = Role::where('slug', 'all')->first();
        $permissions = Permission::all()->each(function($permission) use ($role) {
            $this->command->getOutput()->writeln("<info>attaching $role->slug to $permission->slug</info>");
            $role->permissions()->attach($permission->slug);
        });
    }
}
