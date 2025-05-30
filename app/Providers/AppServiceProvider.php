<?php

namespace App\Providers;

use App\Interfaces\EventConsumer;
use App\Services\KafkaEventConsumer;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(EventConsumer::class, KafkaEventConsumer::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
