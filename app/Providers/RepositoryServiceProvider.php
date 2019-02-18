<?php

namespace App\Providers;

use App\Main\Todo\Repositories\Interfaces\TodoRepositoryInterface;
use App\Main\Todo\Repositories\TodoRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            TodoRepositoryInterface::class,
            TodoRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
