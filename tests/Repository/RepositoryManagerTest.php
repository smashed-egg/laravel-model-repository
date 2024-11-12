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

/**
 * @internal
 *
 * @coversNothing
 */
class RepositoryManagerTest extends TestCase
{
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

        if (is_array($files)) {
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
    }

    public function testResolutionWhenAutoWireIsOn(): void
    {
        $productRepositoryName = 'App\Repositories\ProductRepository';
        $userRepository = $this->createMock(UserRepository::class);

        $productRepository = $this->createMock(ProductRepository::class);
        $container = $this->createMock(Container::class);

        $post = new Post();
        $product = new Product();

        $container
            ->expects($this->any())
            ->method('make')
            ->willReturnMap([
                [User::class, [], $userRepository],
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
            $repositoryManager->get(User::class)
        );

        $this->assertInstanceOf(
            ProductRepository::class,
            $repositoryManager->get(Product::class)
        );

        $this->assertInstanceOf(
            Repository::class,
            $repositoryManager->get(Post::class)
        );
    }

    public function testResolutionWhenAutoWireIsOff(): void
    {
        $userRepository = $this->createMock(UserRepository::class);
        $container = $this->createMock(Container::class);

        $post = new Post();

        $container
            ->expects($this->any())
            ->method('make')
            ->willReturnMap([
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
            $repositoryManager->get(User::class)
        );

        $this->assertInstanceOf(
            Repository::class,
            $repositoryManager->get(Post::class)
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
        ];
    }
}
