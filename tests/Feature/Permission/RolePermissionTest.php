<?php


namespace Tests\Feature\Permission;


use App\Permission;
use App\Role;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RolePermissionTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

	/**
	 * when a permission is added to a role users already having that role should get the newly attached permission
	 * @test
	 */
	public function can_attach_permission_to_role_syncs_user_permissions()
	{
		$this->authenticated();
		$user = factory(User::class)->create();
		$role = factory(Role::class)->create();
		$user->roles()->attach($role->id);
		$permission = factory(Permission::class)->create();

		
		$response = $this->patchJson("roles/{$role->id}/permissions/attach", [
			"slug" => $permission->slug
		]);

		$response->isOk();
		$this->assertDatabaseHas('permission_role', ['role_id' => $role->id, 'permission_slug' => $permission->slug]);
		$this->assertDatabaseHas('permission_user', ['role_id' => $role->id, 'user_id' => $user->id, 'permission_slug' => $permission->slug]);
	}

	/**
	 * when a permission is removed from a role, users already having that role should not have that removed permission
	 * @test
	 */
	public function can_detach_permission_to_role_syncs_user_permissions()
	{
		$this->authenticated();
		$user = factory(User::class)->create();
		$role = factory(Role::class)->create();
		$permission = factory(Permission::class)->create();
		$role->permissions()->attach($permission->slug);
		$user->roles()->attach($role->id);
		$user->permissions()->attach($permission->slug, ['role_id' => $role->id]);
		$this->assertDatabaseHas('permission_role', ['role_id' => $role->id, 'permission_slug' => $permission->slug]);
		$this->assertDatabaseHas('role_user', ['role_id' => $role->id, 'user_id' => $user->id]);
		$this->assertDatabaseHas('permission_user', ['role_id' => $role->id, 'user_id' => $user->id, 'permission_slug' => $permission->slug]);
		
		$response = $this->patchJson("roles/{$role->id}/permissions/detach", [
			"slug" => $permission->slug
		]);

		$response->isOk();
		$this->assertDatabaseHas('permissions', ['slug' => $permission->slug]);
		$this->assertDatabaseHas('users', ['id' => $user->id]);
		$this->assertDatabaseHas('roles', ['id' => $role->id]);
		$this->assertDatabaseMissing('permission_role', ['role_id' => $role->id, 'permission_slug' => $permission->slug]);
		$this->assertDatabaseMissing('permission_user', ['role_id' => $role->id, 'user_id' => $user->id, 'permission_slug' => $permission->slug]);
	}
}