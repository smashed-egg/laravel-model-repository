<?php

namespace SmashedEgg\LaravelModelRepository\Tests;

use Illuminate\Database\Eloquent\SoftDeletes;
use SmashedEgg\LaravelModelRepository\Repository\Repository;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;

class RepositoryTest extends TestCase
{
    public function testModelWorksCorrectlyWithRepository(): void
    {
        $testModel = $this->createMock(Model::class);

        $testModel->expects($this->once())
            ->method('save')
        ;

        $model = $this->createmock(Model::class);
        $repository = new Repository($model);

        $repository->save($testModel);
    }

    public function testModelWithSoftDeletesWorksCorrectlyWithRepository(): void
    {
        $testModel = $this->createMock(ModelWithSoftDeletes::class);

        $testModel->expects($this->once())
            ->method('restore')
            ->willReturn(true)
        ;

        $model = $this->createmock(Model::class);
        $repository = new Repository($model);

        $repository->restore($testModel);
    }
}

class ModelWithSoftDeletes extends Model
{
    use SoftDeletes;
}
