<?php

namespace SmashedEgg\LaravelModelRepository\Repository;

use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Repository
 * @package SmashedEgg\LaravelModelRepository\Repository
 */
class RepositoryManager
{
    /**
     * The container instance.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function get(Model $model): Repository
    {
        return new Repository($model);
    }
}
