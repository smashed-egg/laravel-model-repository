<?php

use SmashedEgg\LaravelModelRepository\Repository\Repository;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;

class RepositoryTest extends TestCase
{
    public function testRepo(): void
    {
        $testModel = $this->createMock(Model::class);

        $testModel->expects($this->once())
            ->method('save')
        ;

        $model = $this->createmock(Model::class);
        $repo = new TestRepo($model);

        $repo->save($testModel);
    }
}


class TestRepo extends Repository
{

}
