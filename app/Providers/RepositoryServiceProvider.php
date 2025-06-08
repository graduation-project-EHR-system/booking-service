<?php
namespace App\Providers;

use App\Interfaces\BookingRepositoryInterface;
use App\Interfaces\DoctorRepositoryInterface;
use App\Services\BookingRepository;
use App\Services\DoctorRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);
        $this->app->bind(DoctorRepositoryInterface::class, DoctorRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
