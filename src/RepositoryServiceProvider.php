<?php

namespace Rez1pro\RepositoryPattern;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register console commands only when running in CLI
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Rez1pro\RepositoryPattern\Console\Commands\CreateRepository::class,
                \Rez1pro\RepositoryPattern\Console\Commands\CreateInterface::class,
            ]);
        }
    }

    public function register()
    {
        //
    }
}