<?php

namespace SmashedEgg\LaravelModelRepository\Repository;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class Repository.
 */
class RepositoryManager
{
    /**
     * @param array{'base_repository': class-string, 'auto_wire': bool, 'model_repository_map': array<class-string, class-string>} $config
     */
    public function __construct(protected Container $container, protected array $config) {}

    /**
     * @template T of Model
     *
     * @param class-string<T> $modelClass
     *
     * @return AbstractRepository<T>
     *
     * @throws BindingResolutionException
     */
    public function get(string $modelClass): AbstractRepository
    {
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

        // @phpstan-ignore-next-line
        return new Repository($this->container->make($modelClass));
    }

    /**
     * Get the given class, without the namespace.
     */
    protected function getClass(string $name): string
    {
        // @var string
        return Arr::last(explode('\\', $name));
    }
}
