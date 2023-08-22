<?php

namespace SmashedEgg\LaravelModelRepository\Repository;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;

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
        if (isset($this->config['model_repository_map'][$modelClass])) {
            return $this->container->make($this->config['model_repository_map'][$modelClass]);
        }

        // If we have auto_wire turned on
        if ($this->config['auto_wire']) {

            // and class exists
            if (class_exists($repoClass = "App\\Repositories\\{$this->getClass($modelClass)}Repository")) {
                $model = $this->container->make($modelClass);

                // then build that
                return $this->container->make(
                    $repoClass,
                    [$model]
                );
            }
        }

        return new Repository($this->container->make($modelClass));
    }

    /**
     * Get the given class, without the namespace
     */
    protected function getClass($name): string
    {
        return Arr::last(explode('\\', $name));
    }
}
