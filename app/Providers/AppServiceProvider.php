<?php

namespace App\Providers;

use App\Repositories\Attendance\AttendanceInterface;
use App\Repositories\Attendance\AttendanceRepository;
use App\Repositories\User\UserInterface;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(AttendanceInterface::class, AttendanceRepository::class);
    }
}
