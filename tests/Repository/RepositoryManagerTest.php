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
        $genericRepository = $this->createMock(Repository::class);
        $container = $this->createMock(Container::class);

        $user = new User();
        $post = new Post();

        $container
            ->expects($this->any())
            ->method('make')
            ->willReturnMap([
                [UserRepository::class, [], $userRepository],
                [Post::class, [], $post],
                [UserRepository::class, [], $userRepository],
                [Post::class, [], $post],
            ])
        ;

        $repositoryManager = new RepositoryManager(
            $container,
            [
                User::class => UserRepository::class,
            ]
        );

        $this->assertInstanceOf(
            UserRepository::class,
            $repositoryManager->get($user)
        );

        $this->assertInstanceOf(
            Repository::class,
            $repositoryManager->get($post)
        );

        $this->assertInstanceOf(
            UserRepository::class,
            $repositoryManager->get(User::class)
        );

        $this->assertInstanceOf(
            Repository::class,
            $repositoryManager->get(Post::class)
        );
    }
}
