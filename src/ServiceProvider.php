<?php

namespace SmashedEgg\LaravelModelRepository;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use SmashedEgg\LaravelModelRepository\Commands\MakeRepositoryCommand;
use SmashedEgg\LaravelModelRepository\Repository\AbstractRepository;
use SmashedEgg\LaravelModelRepository\Repository\RepositoryManager;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
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
            __DIR__.'/Resources/config/model_repository.php',
            'smashed_egg.model_repository'
        );
    }

    public function register(): void
    {
        $this->app->singleton(
            RepositoryManager::class,
            fn (Application $app) => new RepositoryManager($app, $this->getConfigValues())
        );
    }

    /**
     * @return array{'base_repository': class-string, 'auto_wire': bool, 'model_repository_map': array<class-string, class-string>}
     */
    protected function getConfigValues(): array
    {
        // @phpstan-ignore-next-line
        return config('smashed_egg.model_repository.model_repository_map', [
            'base_repository' => AbstractRepository::class,
            'auto_wire' => true,
            'model_repository_map' => [],
        ]);
    }
}
