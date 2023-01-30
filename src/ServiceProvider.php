<?php

namespace SmashedEgg\LaravelModelRepository;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use SmashedEgg\LaravelModelRepository\Commands\MakeRepositoryCommand;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->commands([
            MakeRepositoryCommand::class,
        ]);
    }
}
