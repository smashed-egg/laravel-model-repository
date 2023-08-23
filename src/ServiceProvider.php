<?php

namespace SmashedEgg\LaravelModelRepository;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use SmashedEgg\LaravelModelRepository\Commands\MakeRepositoryCommand;
use SmashedEgg\LaravelModelRepository\Repository\RepositoryManager;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeRepositoryCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__.'/Resources/config/model_repository.php' => config_path('smashed_egg/model_repository.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__.'/Resources/config/model_repository.php', 'smashed_egg.model_repository'
        );
    }

    public function register()
    {
        $this->app->singleton(RepositoryManager::class, function(Application $app) {
            return new RepositoryManager(
                $app,
                config('smashed_egg.model_repository.model_repository_map', [])
            );
        });
    }
}
