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
    public function get(Model $model): Repository
    {
        if (isset($this->config[$model::class])) {
            return $this->container->make($this->config[$model::class]);
        }
        return new Repository($model);
    }
}
