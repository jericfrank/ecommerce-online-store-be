<?php

namespace App\Providers;

use App\Services\Interfaces\UserInterface;
use App\Services\Interfaces\UserProviderInterface;
use App\Services\Interfaces\ItemInterface;
use App\Services\Interfaces\CategoryInterface;
use App\Services\Interfaces\CartInterface;

use App\Services\Repositories\UserRepository;
use App\Services\Repositories\UserProviderRepository;
use App\Services\Repositories\ItemRepository;
use App\Services\Repositories\CategoryRepository;
use App\Services\Repositories\CartRepository;

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

        $this->app->bind(
            ItemInterface::class,
            ItemRepository::class
        );

        $this->app->bind(
            CategoryInterface::class,
            CategoryRepository::class
        );

        $this->app->bind(
            CartInterface::class,
            CartRepository::class
        );
    }
}
