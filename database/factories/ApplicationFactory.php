<?php

use App\Application;
use App\Business;
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

$factory->define(Application::class, function (Faker $faker) {
	$twoOptions = ["1", "2"];
	$threeOptions = ["1", "2"];
      $fourOptions = ["1", "2"];
      $randomBool = (bool)random_int(0, 1);

	$states = ['draft', 'pending', 'processed', 'cancelled'];


    return [
      "business_id" =>  null,
      "status" =>  $states[array_rand($states)],
      "_1applicationType" =>  $twoOptions[array_rand($twoOptions)],
      "_1date" =>  str_random(10),
      "_1registerPlace" =>  $fourOptions[array_rand($fourOptions)],
      "_1registrationNumber" =>  str_random(10),
      "_1renewLicense" =>  $threeOptions[array_rand($threeOptions)],
      "_1toRegisterPlace" =>  ($randomBool) ? true: false,
      "_1toRenewLicense" =>  ($randomBool) ? false: true,
      "_1tobaccoOrFood" =>  "2",
      "_1wantLicenseIndhivehi" =>  (bool)random_int(0, 1),
      "_1wantLicenseInenglish" =>  (bool)random_int(0, 1),
      "_2address" =>  str_random(10),
      "_2idNo" =>  str_random(10),
      "_2name" =>  str_random(10),
      "_2phone" =>  str_random(10),
      "_3address" =>  str_random(10),
      "_3idNo" =>  str_random(10),
      "_3name" =>  str_random(10),
      "_3phone" =>  str_random(10),
      "_4blockNumber" =>  str_random(10),
      "_4numberOfChairs" =>  str_random(10),
      "_4numberOfServingAreas" =>  str_random(10),
      "_4placeAddress" =>  str_random(10),
      "_4placeName" =>  str_random(10),
      "_4road" =>  str_random(10),
      "_5cat101" =>  "0",
      "_5cat101text" =>  str_random(10),
      "_5cat11" =>  (bool)random_int(0, 1),
      "_5cat12" =>  (bool)random_int(0, 1),
      "_5cat13" =>  (bool)random_int(0, 1),
      "_5cat14" =>  (bool)random_int(0, 1),
      "_5cat15" =>  (bool)random_int(0, 1),
      "_5cat21" =>  (bool)random_int(0, 1),
      "_5cat31" =>  (bool)random_int(0, 1),
      "_5cat32" =>  (bool)random_int(0, 1),
      "_5cat33" =>  (bool)random_int(0, 1),
      "_5cat41" =>  (bool)random_int(0, 1),
      "_5cat42" =>  (bool)random_int(0, 1),
      "_5cat43" =>  (bool)random_int(0, 1),
      "_5cat51" =>  (bool)random_int(0, 1),
      "_5cat61" =>  (bool)random_int(0, 1),
      "_5cat62" =>  (bool)random_int(0, 1),
      "_5cat71" =>  (bool)random_int(0, 1),
      "_5cat81" =>  (bool)random_int(0, 1),
      "_5cat91" =>  (bool)random_int(0, 1),
    ];
});

$factory->defineAs(Application::class, 'new_food_permit', function (Faker $faker) use ($factory) {
    $application = $factory->raw(Application::class);
    return array_replace($application, [
        "status" =>  'draft',
        "_1tobaccoOrFood" => "2",
        "_1applicationType" => "1",
        "_1toRegisterPlace" => true,
        "_1toRenewLicense" => false,
        "_1registerPlace" => "1",
        "_1renewLicense" => "1",
    ]);
});

$factory->defineAs(Application::class, 'renew_food_permit', function (Faker $faker) use ($factory) {
    $application = $factory->raw(Application::class);
    return array_replace($application, [
        "status" =>  'draft',
        "_1tobaccoOrFood" => "2",
        "_1applicationType" => "2",
        "_1toRegisterPlace" => false,
        "_1toRenewLicense" => true,
        "_1registerPlace" => "1",
        "_1renewLicense" => "1",
    ]);
});

$factory->defineAs(Application::class, 'new_tobacco_permit', function (Faker $faker) use ($factory) {
    $application = $factory->raw(Application::class);
    $business = factory(Business::class)->create();
    return array_replace($application, [
        "status" =>  'draft',
        "business_id" => $business->id,
        "_1registrationNumber" => $business->registration_no,
        "_1tobaccoOrFood" => "1",
        "_1applicationType" => "1",
        "_1toRegisterPlace" => true,
        "_1toRenewLicense" => false,
        "_1registerPlace" => "1",
        "_1renewLicense" => "1",
    ]);
});
