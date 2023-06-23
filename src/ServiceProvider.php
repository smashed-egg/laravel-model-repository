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

        $this->publishes([
            __DIR__.'/Resources/config/model_repository.php' => config_path('smashedegg/model_repository.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__.'/Resources/config/model_repository.php', 'smashedegg.model_repository'
        );
    }
}
