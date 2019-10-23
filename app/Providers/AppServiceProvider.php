<?php

namespace App\Providers;

use App\Console\Commands\PermissionSync;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use DB;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Schema::defaultStringLength(191);

        // DB::listen(function ($query) {
        //     \Log::info('quey: ' . $query->sql);
        //     \Log::info('bindings: ' . json_encode($query->bindings));
        //     // var_dump([
        //     //     $query->sql,
        //     //     $query->bindings,
        //     //     $query->time
        //     // ]);
        // });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            PermissionSync::class
        ]);
    }
}
