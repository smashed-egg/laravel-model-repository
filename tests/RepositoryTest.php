<?php

namespace SmashedEgg\LaravelModelRepository\Tests;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use PHPUnit\Framework\TestCase;
use SmashedEgg\LaravelModelRepository\Exception\ModelRestoreNotSupportedException;
use SmashedEgg\LaravelModelRepository\Repository\Repository;

/**
 * @internal
 *
 * @coversNothing
 */
class RepositoryTest extends TestCase
{
    public function testQueryBaseQueryBuilderIsReturned(): void
    {
        $model = $this->createMock(Model::class);

        $builder = $this->createMock(EloquentBuilder::class);

        $builder->expects($this->once())
            ->method('getQuery')
            ->willReturn($this->createMock(Builder::class))
        ;

        $model->expects($this->once())
            ->method('newQuery')
            ->willReturn($builder)
        ;

        $model->expects($this->once())
            ->method('newQuery')
            ->willReturn($builder)
        ;

        $repository = new Repository($model);

        $this->assertInstanceOf(Builder::class, $repository->baseQuery());
    }

    public function testQueryEloquentQueryBuilderIsReturned(): void
    {
        $model = $this->createMock(Model::class);
        $repository = new Repository($model);

        $builder = $this->createMock(EloquentBuilder::class);

        $model->expects($this->once())
            ->method('newQuery')
            ->willReturn($builder)
        ;

        $this->assertInstanceOf(EloquentBuilder::class, $repository->query());
    }

    public function testModelWorksCorrectlyWithRepository(): void
    {
        $testModel = $this->createMock(Model::class);

        $testModel->expects($this->once())
            ->method('save')
            ->willReturn(true)
        ;

        $model = $this->createmock(Model::class);
        $repository = new Repository($model);

        $this->assertTrue($repository->save($testModel));
    }

    public function testModelWithSoftDeletesWorksCorrectlyWithRepository(): void
    {
        $testModel = $this->createMock(ModelWithSoftDeletes::class);

        $testModel->expects($this->once())
            ->method('restore')
            ->willReturn(true)
        ;

        $testModel->expects($this->once())
            ->method('forceDelete')
            ->willReturn(true)
        ;

        $testModel->expects($this->once())
            ->method('delete')
            ->willReturn(true)
        ;

        $model = $this->createmock(Model::class);
        $repository = new Repository($model);

        $this->assertTrue($repository->restore($testModel));
        $this->assertTrue($repository->delete($testModel, true));
        $this->assertTrue($repository->delete($testModel));
    }

    public function testModelWithoutSoftDeletesFailsCorrectly(): void
    {
        $this->expectException(ModelRestoreNotSupportedException::class);
        $model = $this->createmock(Model::class);
        $repository = new Repository($model);

        $this->assertTrue($repository->restore($model));
    }
}

class ModelWithSoftDeletes extends Model
{
    use SoftDeletes;
}
