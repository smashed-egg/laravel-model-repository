<?php

namespace SmashedEgg\LaravelModelRepository\Repository;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AbstractRepository
 * @package Tomgrohl\Laravel\Repository
 */
abstract class AbstractRepository
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return Builder
     */
    public function query()
    {
        return $this->model->newQuery();
    }

    /**
     * @return QueryBuilder
     */
    public function baseQuery()
    {
        return $this->query()->getQuery();
    }

    /**
     * Delete a model
     *
     * @param Model $model
     * @param false|bool $force When a model uses SoftDeletes, this will force it to be deleted
     * @return bool
     * @throws Exception
     */
    public function delete(Model $model, bool $force = false)
    {
        if ($model instanceof SoftDeletes && $force) {
            return $model->forceDelete();
        }

        return $model->delete();
    }

    /**
     * Restore a soft deleted model
     *
     * @param Model|SoftDeletes $model
     * @return mixed
     */
    public function restore(Model $model)
    {
        return $model->restore();
    }

    /**
     * Save a model
     *
     * @param Model $model
     * @return bool
     */
    public function save(Model $model)
    {
        return $model->save();
    }
}
