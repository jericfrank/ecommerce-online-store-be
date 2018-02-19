<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use App\Repositories\UserProviderRepository;

use App\Repositories\Interfaces\UserInterface;
use App\Repositories\Interfaces\UserProviderInterface;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UserInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            UserProviderInterface::class,
            UserProviderRepository::class
        );
    }
}
