<?php

use SmashedEgg\LaravelModelRepository\Repository\AbstractRepository;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;

class AbstractRepositoryTest extends TestCase
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


class TestRepo extends AbstractRepository
{

}
