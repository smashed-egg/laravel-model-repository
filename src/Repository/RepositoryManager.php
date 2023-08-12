<?php

namespace SmashedEgg\LaravelModelRepository\Repository;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Repository
 * @package SmashedEgg\LaravelModelRepository\Repository
 */
class RepositoryManager
{
    public function __construct(protected Container $container, protected array $config)
    {}

    /**
     * @throws BindingResolutionException
     */
    public function get(Model|string $model): Repository
    {
        $modelClass = is_string($model) ? $model : $model::class;
        if (isset($this->config[$modelClass])) {
            return $this->container->make($this->config[$modelClass]);
        }

        return new Repository($this->container->make($modelClass));
    }
}
