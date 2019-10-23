<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Business::class, function (Faker $faker) {
    return [
		'name' => $faker->name,
		'name_dv' => $faker->name,
		'phone' => '9999999',
		'country' => $faker->country,
		'registration_no' => str_random(10),
		'identification_code' => str_random(10),
		'date_of_inspection' => Carbon::now(),
		'logo' => str_random(10),
		'license_id' => 1,
		'is_active' => true,
		'is_expired' => false,
		'active_at' => Carbon::now(),
		'expire_at' => Carbon::now()->addMonth(),
    ];
});
