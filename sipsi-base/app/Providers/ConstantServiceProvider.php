<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Constant;

class ConstantServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Constant::initialize();
    }
} 