<?php

use App\Application;
use App\Business;
use App\GradingInspection;
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

$factory->define(GradingInspection::class, function (Faker $faker) {
        $status = ['scheduled', 'finished', 'cancelled'];

      return [
        'business_id' => function() {
              return factory(Business::class)->create()->id;
        },
        // 'business_id' => null,
        'application_id' => function() {
              return factory(Application::class)->create()->id;
        },
        // 'application_id' => null,
        'inspection_at' => Carbon::now()->addDays(20),
        'status' => $status[array_rand($status)],
        // 'grading_form_id' => function() {
        //       return factory(DhivehiReport::class)->create()->id;
        // },
        'grading_form_id' => null,
    ];

});
