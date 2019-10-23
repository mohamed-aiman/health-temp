<?php

use App\Business;
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

$factory->define(App\Termination::class, function (Faker $faker) {
    return [
        'terminated_on' => Carbon::now(),
        'reason' => $faker->text(5),
        'business_id' => function() {
        	return factory(Business::class)->create()->id;
        }
    ];
});
