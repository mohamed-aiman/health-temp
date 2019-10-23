<?php

use App\GradingPoint;
use Faker\Generator as Faker;

$factory->define(GradingPoint::class, function (Faker $faker) {
    return [
        'no' => $faker->text(4),
        'code' => $faker->text(4),
        'text' => $faker->text(100),
        'group' => $faker->text(100),
        'is_active' => (bool) random_int(0, 1),
    ];
});
