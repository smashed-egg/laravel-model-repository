<?php

namespace SmashedEgg\LaravelModelRepository\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase;
use SmashedEgg\LaravelModelRepository\Repository\Repository;
use SmashedEgg\LaravelModelRepository\Repository\RepositoryManager;
use SmashedEgg\LaravelModelRepository\ServiceProvider;
use SmashedEgg\LaravelModelRepository\Tests\Model\User;
use SmashedEgg\LaravelModelRepository\Tests\Repository\UserRepository;

/**
 * @internal
 *
 * @coversNothing
 */
class ServiceProviderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config('smashed_egg.model_repository', [
            'base_repository' => Repository::class,

            'auto_wire' => true,

            'model_repository_map' => [
                User::class => UserRepository::class,
            ],
        ]);
    }

    public function testServiceProviderRegistersCorrectly(): void
    {
        $this->assertInstanceOf(
            RepositoryManager::class,
            $this->getApplication()->make(RepositoryManager::class)
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    protected function getApplication(): Application
    {
        if (null === $this->app) {
            throw new \RuntimeException('No application available');
        }

        return $this->app;
    }
}
