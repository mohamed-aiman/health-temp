<?php

use App\DhivehiReport;
use App\Inspection;
use App\User;
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

$factory->define(DhivehiReport::class, function (Faker $faker) {
    return [
        // 'inspection_id' => function() {
        //       return factory(Inspection::class)->create()->id;
        // },
        'inspection_id' => null,
        // 'scope' => $faker->text(100),
        'critical' => null,
        'major' => null,
        'minor' => null,
        'tobacco' => null,
        
        'fine_slip_numbers' => null,

        'critical_totals' => null,
        'major_totals' => null,
        'minor_totals' => null,
        'tobacco_totals' => null,

        'purpose' => $faker->text(100),
        'place_name_address' => $faker->text(100),
        'place_owner_name_address' => $faker->text(100),
        'phone' => $faker->text(100),
        'information_provider' => $faker->text(100),
        'number_of_inspections' => random_int(0, 1000),
        'time_of_inspection' => $faker->text(100),

        'issued_by' => function() {
            return factory(User::class)->create()->id;
        },
        'issued_on' => Carbon::now()->format('Y-m-d H:i:s'),
        'received_by' => $faker->name,
        'hard_copy_path' => $faker->url,

        // 'areas' => $faker->text(100),
        // 'comments' => $faker->text(100),
        // 'verified_by' => 1,
        // 'inspectionMember1Name' => $faker->text(100),
        // 'inspectionMember1Designation' => $faker->text(100),
        // 'inspectionMember1Date' => $faker->text(100),
        // 'inspectionMember2Name' => $faker->text(100),
        // 'inspectionMember2Designation' => $faker->text(100),
        // 'inspectionMember2Date' => $faker->text(100),
        // 'verifiedByName' => $faker->text(100),
        // 'verifiedByDesignation' => $faker->text(100),
        // 'verifiedByDate' => $faker->text(100),
    ];
});