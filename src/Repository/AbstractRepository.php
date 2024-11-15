<?php

namespace SmashedEgg\LaravelModelRepository\Repository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder as QueryBuilder;
use SmashedEgg\LaravelModelRepository\Exception\ModelRestoreNotSupportedException;

/**
 * @template TModel of Model
 */
abstract class AbstractRepository
{
    /**
     * Constructor.
     *
     * @param TModel $model
     */
    public function __construct(protected Model $model) {}

    /**
     * @return Builder<TModel>
     */
    public function query(): Builder
    {
        return $this->model->newQuery();
    }

    public function baseQuery(): QueryBuilder
    {
        return $this->query()->getQuery();
    }

    public function delete(Model $model, bool $force = false): ?bool
    {
        if ($force && $this->modelSupportsTrait($model, SoftDeletes::class)) {
            return $model->forceDelete();
        }

        return $model->delete();
    }

    /**
     * @throws ModelRestoreNotSupportedException
     */
    public function restore(Model $model): bool
    {
        if ( ! $this->modelSupportsTrait($model, SoftDeletes::class)) {
            throw new ModelRestoreNotSupportedException();
        }

        // @phpstan-ignore-next-line
        return $model->restore();
    }

    public function save(Model $model): ?bool
    {
        return $model->save();
    }

    public function modelSupportsTrait(Model $model, string $trait): bool
    {
        return in_array($trait, class_uses_recursive($model));
    }
}
