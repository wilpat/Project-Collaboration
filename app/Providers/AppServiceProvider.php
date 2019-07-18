<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
/*use App\Project;
use App\Task;
use App\Observers\ProjectObserver;
use App\Observers\TaskObserver;*/


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        // Project::observe(ProjectObserver::class);
        // Task::observe(TaskObserver::class);
    }
}
