<?php

use App\Inspection;
use App\NormalForm;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(NormalForm::class, function (Faker $faker) {
    return [
		'reason' => $faker->word(3),
		'applied_for' => $faker->word(3),
		'applied_date' => Carbon::now()->subDays(4)->format('Y-m-d H:i:s'),
		'place_name_address' => $faker->word(3),
		'registration_no' => $faker->bothify('REG######??'),
		'place_owner_name_address' => $faker->name,
		'permit_expiry_date' => Carbon::now()->addYear()->format('Y-m-d H:i:s'),
		'phone' => random_int(7000000, 9999999),
		'chair_count' => random_int(10, 48),
		'serving_area_count' => random_int(0, 3),
		'info_provider_name_no' => $faker->name,
		'kitchen_count' => random_int(0, 4),
		'inspected_at' => Carbon::now()->addDays(34)->format('Y-m-d H:i:s'),
		'normal_inspection_id' => function() {
			return factory(Inspection::class)->create()->id;
		},
		'status' => 'draft',
    ];
});
