<?php

use App\Business;
use App\License;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(License::class, function (Faker $faker) {
    return [
        'business_id' => function() {
            return factory(Business::class)->create()->id;
        },
        'application_id' => function() {
            return factory(Business::class)->create()->id;
        },
        'type' => (string) random_int(1, 2),
        'license_no' => $faker->text(30),
        'issued_at' => Carbon::now()->subMonths(2),
        'expire_at' => Carbon::now()->addMonths(2),
    ];
});