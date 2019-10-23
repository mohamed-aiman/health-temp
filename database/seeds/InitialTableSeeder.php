<?php

use App\Application;
use App\Business;
use App\DhivehiReport;
use App\EnglishReport;
use App\Inspection;
use App\User;
use Illuminate\Database\Seeder;

class InitialTableSeeder extends Seeder
{
    public function run()
    {
        factory(User::class, 20)->create();
        factory(Business::class, 50)->create();
        factory(Application::class, 70)->create();
        factory(Inspection::class, 70)->create();
        factory(DhivehiReport::class, 70)->create();
        factory(EnglishReport::class, 60)->create();
    }
}
