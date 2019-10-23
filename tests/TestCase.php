<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public $user;

	public function authenticated($user = null)
	{
		if (!$user) {
			$user = factory(User::class)->create([
				'email' => 'muhammadhu.aiman@gmail.com'
			]);
		}

		$this->user = $user;

		return parent::actingAs($user);
	}

	public function hasPermission($slug)
	{
		//give permission to the authenticated user
	}
}
