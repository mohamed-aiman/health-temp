<?php


namespace Tests\Feature\Permission;


use App\Permission;
use App\Role;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GradingInspectionCreateTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

	/**
	 * @test
	 */
	public function can_attach_role_to_user_with_permissions()
	{
		$this->authenticated();
		$user = factory(User::class)->create();
		$role = factory(Role::class)->create();
		$permission1 = factory(Permission::class)->create();
		$permission2 = factory(Permission::class)->create();
		$permission3 = factory(Permission::class)->create();
		$role->permissions()->attach($permission1->slug);
		$role->permissions()->attach($permission2->slug);
		$role->permissions()->attach($permission3->slug);

		$response = $this->patchJson("users/{$user->id}/roles/attach", [
			"role_id" => $role->id
		]);

		$response->isOk();
		$this->assertDatabaseHas('permission_role', ['role_id' => $role->id, 'permission_slug' => $permission1->slug]);
		$this->assertDatabaseHas('permission_role', ['role_id' => $role->id, 'permission_slug' => $permission2->slug]);
		$this->assertDatabaseHas('permission_role', ['role_id' => $role->id, 'permission_slug' => $permission3->slug]);
		$this->assertDatabaseHas('role_user', ['role_id' => $role->id, 'user_id' => $user->id]);
		$this->assertDatabaseHas('permission_user', ['role_id' => $role->id, 'user_id' => $user->id, 'permission_slug' => $permission1->slug]);
		$this->assertDatabaseHas('permission_user', ['role_id' => $role->id, 'user_id' => $user->id, 'permission_slug' => $permission2->slug]);
		$this->assertDatabaseHas('permission_user', ['role_id' => $role->id, 'user_id' => $user->id, 'permission_slug' => $permission3->slug]);
	}

	/**
	 * @test
	 */
	public function can_detach_role_from_user_with_permissions()
	{
		$this->authenticated();
		$user = factory(User::class)->create();
		$role = factory(Role::class)->create();
		$permission1 = factory(Permission::class)->create();
		$permission2 = factory(Permission::class)->create();
		$permission3 = factory(Permission::class)->create();
		$role->permissions()->attach($permission1->slug);
		$role->permissions()->attach($permission2->slug);
		$role->permissions()->attach($permission3->slug);
		$user->roles()->attach($role->id);
		$user->permissions()->attach($permission1->slug, ['role_id' => $role->id]);
		$user->permissions()->attach($permission2->slug, ['role_id' => $role->id]);
		$user->permissions()->attach($permission3->slug, ['role_id' => $role->id]);
		// $this->assertDatabaseHas('permission_role', ['role_id' => $role->id, 'permission_slug' => $permission1->slug]);
		// $this->assertDatabaseHas('permission_role', ['role_id' => $role->id, 'permission_slug' => $permission2->slug]);
		// $this->assertDatabaseHas('permission_role', ['role_id' => $role->id, 'permission_slug' => $permission3->slug]);
		// $this->assertDatabaseHas('role_user', ['role_id' => $role->id, 'user_id' => $user->id]);
		// $this->assertDatabaseHas('permission_user', ['role_id' => $role->id, 'user_id' => $user->id, 'permission_slug' => $permission1->slug]);
		// $this->assertDatabaseHas('permission_user', ['role_id' => $role->id, 'user_id' => $user->id, 'permission_slug' => $permission2->slug]);
		// $this->assertDatabaseHas('permission_user', ['role_id' => $role->id, 'user_id' => $user->id, 'permission_slug' => $permission3->slug]);


		$response = $this->patchJson("users/{$user->id}/roles/detach", [
			"role_id" => $role->id
		]);
		$response->isOk();
		$this->assertDatabaseHas('permission_role', ['role_id' => $role->id, 'permission_slug' => $permission1->slug]);
		$this->assertDatabaseHas('permission_role', ['role_id' => $role->id, 'permission_slug' => $permission2->slug]);
		$this->assertDatabaseHas('permission_role', ['role_id' => $role->id, 'permission_slug' => $permission3->slug]);
		$this->assertDatabaseMissing('role_user', ['role_id' => $role->id, 'user_id' => $user->id]);
		$this->assertDatabaseMissing('permission_user', ['role_id' => $role->id, 'user_id' => $user->id, 'permission_slug' => $permission1->slug]);
		$this->assertDatabaseMissing('permission_user', ['role_id' => $role->id, 'user_id' => $user->id, 'permission_slug' => $permission2->slug]);
		$this->assertDatabaseMissing('permission_user', ['role_id' => $role->id, 'user_id' => $user->id, 'permission_slug' => $permission3->slug]);
	}
}