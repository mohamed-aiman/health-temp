<?php

use App\Application;
use App\Business;
use App\DhivehiReport;
use App\EnglishReport;
use App\Inspection;
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

$factory->define(Inspection::class, function (Faker $faker) {
        $status = ['scheduled', 'finished', 'cancelled'];
        $states = [
            'logged',
            'scheduled',
            'filling_checklist'
        ];

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
        'type' => $faker->word,
        'reason' => $faker->word(3),
        'remarks' => $faker->word(3),
        'is_fined' => false,
        'is_followup_required' => false,
        'report_handed_over_at' => Carbon::now()->addDays(20),
        'status' => 'scheduled',
        'state' => 'scheduled',
        'dhivehi_report_id' => function() {
              return factory(DhivehiReport::class)->create()->id;
        },
        'normal_form_id' => null,
        // 'dhivehi_report_id' => null,
        'english_report_id' => function() {
              return factory(EnglishReport::class)->create()->id;
        },
        // 'follow_up_id' => function() {
        //       return factory(Inspection::class)->create()->id;
        // }
        'follow_up_id' => null,
        'english_report_id' => null,
    ];

});
