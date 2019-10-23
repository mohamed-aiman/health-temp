<?php

use App\Fine;
use Illuminate\Database\Seeder;

class FinesTableSeeder extends Seeder
{
    public function run()
    {
        factory(Fine::class, 20)->create();
    }
}
