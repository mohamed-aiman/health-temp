<?php

use App\License;
use Illuminate\Database\Seeder;

class LicensesTableSeeder extends Seeder
{
    public function run()
    {
        factory(License::class, 20)->create();
    }
}
