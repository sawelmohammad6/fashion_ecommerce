<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Blade::componentNamespace('App\\View\\Components', 'admin');
        Blade::anonymousComponentPath(resource_path('views/admin/components'), 'admin');
    }
}
