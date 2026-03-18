<?php

namespace App\Providers;

use App\Events\ProjectArchived;
use App\Listeners\ProjectArchivedListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Event::listen(
            ProjectArchived::class,
            ProjectArchivedListener::class
        );
    }
}
