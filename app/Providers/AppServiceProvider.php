<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\View\Components\Auth\Layout;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Blade::component('auth.layout', Layout::class);
        Blade::component('layouts.admin', \App\View\Components\Layouts\Admin::class);
    }
}
