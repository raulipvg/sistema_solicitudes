<?php

namespace App\Providers;

use Monolog\Processor\ProcessorInterface;
use Illuminate\Support\ServiceProvider;
use App\Logging\CustomContextProcessor;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->singleton(ProcessorInterface::class, CustomContextProcessor::class);//
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
