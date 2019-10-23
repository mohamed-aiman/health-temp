<?php

use App\Application;
use App\Business;
use App\DhivehiReport;
use App\EnglishReport;
use App\Fine;
use App\GradingInspection;
use App\Inspection;
use App\License;
use App\Termination;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateAll();

        \Artisan::call('permission:sync');
        
        // $this->call(InitialTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RolesPermissionsTableSeeder::class);
        $this->call(SubRolesPermissionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(UsersRolesTableSeeder::class);
        $this->call(FineTypesTableSeeder::class);
        $this->call(FeeTypesTableSeeder::class);
        $this->call(GradingPointsTableSeeder::class);
        $this->call(NormalPointsTableSeeder::class);
        // factory(Business::class, 30)->create();
        // factory(Application::class, 40)->create();
        // factory(Inspection::class, 40)->create();
        // factory(DhivehiReport::class, 40)->create();
        // factory(EnglishReport::class, 20)->create();
        // factory(Fine::class, 30)->create();
        // factory(License::class, 30)->create();
        // factory(GradingInspection::class, 30)->create();
    }

    public static function truncateAll()
    {
        \DB::statement("SET foreign_key_checks=0");
        $databaseName = \DB::getDatabaseName();
        $tables = \DB::select("SELECT * FROM information_schema.tables WHERE table_schema = '$databaseName'");
        foreach ($tables as $table) {
            $name = $table->TABLE_NAME;
            //if you don't want to truncate migrations
            if (in_array($name, [
                'migrations',
                'applications',
                'inspections',
                'businesses',
                'normal_form_points',
                'normal_forms',
                'normal_categories',
                'normal_points',
                'dhivehi_reports',
                'english_reports',
                'dhivehi_report_normal_form_point',
            ])) {
                continue;
            }
            \DB::table($name)->truncate();
        }
        \DB::statement("SET foreign_key_checks=1");
    }
}
