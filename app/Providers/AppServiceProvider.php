<?php

namespace App\Providers;

use App\Interfaces\UserInterface;
use App\Repositories\UserRepository;
use App\Interfaces\PositionInterface;
use App\Repositories\PositionRepository;
use App\Interfaces\OrganizationInterface;
use App\Interfaces\SubjectInterface;
use App\Repositories\OrganizationRepository;
use App\Repositories\SubjectRepository;
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
        $this->app->singleton(UserInterface::class, UserRepository::class);
        $this->app->singleton(PositionInterface::class, PositionRepository::class);
        $this->app->singleton(OrganizationInterface::class, OrganizationRepository::class);
        $this->app->singleton(SubjectInterface::class, SubjectRepository::class);
    }
}
