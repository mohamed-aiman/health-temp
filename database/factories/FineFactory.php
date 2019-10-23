<?php

use App\Business;
use App\Fine;
use App\FineType;
use App\Inspection;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(FineType::class, function (Faker $faker) {
    return [
        'amount' => random_int(1, 200),
        'description' => $faker->text(30),
    ];
});

$factory->define(Fine::class, function (Faker $faker) {
    return [
        'business_id' => function() {
            return factory(Business::class)->create()->id;
        },
        'inspection_id' => function() {
            return factory(Inspection::class)->create()->id;
        },
        'amount' => random_int(1, 200),
        'fined_on' => Carbon::now()->subMonths(3),
        'is_paid' => random_int(0, 1),
        'receipt_no' => $faker->uuid,
        'paid_on' => Carbon::now()->subMonths(2),
        'receipt_path' => $faker->url,
        'remarks' => $faker->text(30),
        'fine_type_id' => factory(FineType::class)->create()->id,
    ];
});