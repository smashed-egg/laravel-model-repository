<?php

namespace SmashedEgg\LaravelModelRepository\Tests\Repository;

use Illuminate\Contracts\Container\Container;
use PHPUnit\Framework\TestCase;
use SmashedEgg\LaravelModelRepository\Repository\Repository;
use SmashedEgg\LaravelModelRepository\Repository\RepositoryManager;
use SmashedEgg\LaravelModelRepository\Tests\Model\Post;
use SmashedEgg\LaravelModelRepository\Tests\Model\User;

class RepositoryManagerTest extends TestCase
{
    public function testSomething()
    {
        $userRepository = $this->createMock(UserRepository::class);
        $container = $this->createMock(Container::class);

        $container->expects($this->once())
            ->method('make')
            ->with(UserRepository::class, [])
            ->willReturn($userRepository)
        ;


        $repositoryManager = new RepositoryManager(
            $container,
            [
                User::class => UserRepository::class,
            ]
        );

        $this->assertInstanceOf(
            UserRepository::class,
            $repositoryManager->get(new User())
        );

        $this->assertInstanceOf(
            Repository::class,
            $repositoryManager->get(new Post())
        );
    }
}
