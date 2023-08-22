<?php

namespace SmashedEgg\LaravelModelRepository\Tests\Repository;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Artisan;
use Orchestra\Testbench\TestCase;
use SmashedEgg\LaravelModelRepository\Repository\Repository;
use SmashedEgg\LaravelModelRepository\Repository\RepositoryManager;
use SmashedEgg\LaravelModelRepository\ServiceProvider;
use SmashedEgg\LaravelModelRepository\Tests\Model\Post;
use SmashedEgg\LaravelModelRepository\Tests\Model\Product;
use SmashedEgg\LaravelModelRepository\Tests\Model\User;

class RepositoryManagerTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    public function setUp(): void
    {
        parent::setUp();

        // Create product repository: App\Repositories\ProductRepository
        Artisan::call('smashed-egg:make:repository', [
            'name' => 'ProductRepository',
        ]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $files = glob(app_path('Repositories/*'));
        foreach($files as $file){
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    public function testResolutionWhenAutoWireIsOn()
    {
        $productRepositoryName = "App\\Repositories\\ProductRepository";

        $userRepository = $this->createMock(UserRepository::class);
        $postRepository = $this->createMock(Repository::class);

        $productRepository = $this->createMock($productRepositoryName);
        $container = $this->createMock(Container::class);

        $user = new User();
        $post = new Post();
        $product = new Product();

        $container
            ->expects($this->any())
            ->method('make')
            ->willReturnMap([
                [UserRepository::class, [], $userRepository],
                [UserRepository::class, [], $userRepository],
                [Product::class, [], $product],
                [$productRepositoryName, [$product], $productRepository],
                [Post::class, [], $post],
            ])
        ;

        $repositoryManager = new RepositoryManager(
            $container,
            [
                'base_repository' => Repository::class,
                'auto_wire' => true,
                'model_repository_map' => [
                    User::class => UserRepository::class,
                ],
            ]
        );

        $this->assertInstanceOf(
            UserRepository::class,
            $repositoryManager->get($user)
        );

        $this->assertInstanceOf(
            UserRepository::class,
            $repositoryManager->get(User::class)
        );

        $this->assertInstanceOf(
            $productRepositoryName,
            $repositoryManager->get(Product::class)
        );

        $this->assertInstanceOf(
            Repository::class,
            $repositoryManager->get(Post::class)
        );
    }

    public function testResolutionWhenAutoWireIsOff()
    {
        $userRepository = $this->createMock(UserRepository::class);
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
                'base_repository' => Repository::class,
                'auto_wire' => false,
                'model_repository_map' => [
                    User::class => UserRepository::class,
                ],
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
