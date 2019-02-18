<?php

namespace App\Providers;

use App\Repositories\TodoRepository;
use App\Repositories\TodoRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

//    /**
//     * All of the container bindings that should be registered.
//     *
//     * @var array
//     */
//    public $bindings = [
//        TodoRepositoryInterface::class => TodoRepository::class,
//    ];


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
//        $this->app->bind(
//            'App\Repositories\TodoRepositoryInterface',
//            'App\Repositories\TodoRepository'
//        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
