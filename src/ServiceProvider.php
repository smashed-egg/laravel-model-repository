<?php

namespace SmashedEgg\LaravelModelRepository;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use SmashedEgg\LaravelModelRepository\Commands\MakeRepositoryCommand;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeRepositoryCommand::class,
            ]);
        }
    }
}
