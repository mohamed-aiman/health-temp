<?php

use App\EnglishReport;
use App\Inspection;
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

$factory->define(EnglishReport::class, function (Faker $faker) {
    return [
        // 'inspection_id' => function() {
        //       return factory(Inspection::class)->create()->id;
        // },
        'inspection_id' => 1,
        'scope' => $faker->text(100),
        'critical' => null,//$faker->text(100),
        'major' => null,//$faker->text(100),
        'observations' => null,//$faker->text(100),
        'areas' => $faker->text(100),
        'comments' => $faker->text(100),
        // 'verified_by' => null,
        'inspectionMember1Name' => $faker->text(100),
        'inspectionMember1Designation' => $faker->text(100),
        'inspectionMember1Date' => $faker->text(100),
        'inspectionMember2Name' => $faker->text(100),
        'inspectionMember2Designation' => $faker->text(100),
        'inspectionMember2Date' => $faker->text(100),
        'verifiedByName' => $faker->text(100),
        'verifiedByDesignation' => $faker->text(100),
        'verifiedByDate' => $faker->text(100),
    ];
});