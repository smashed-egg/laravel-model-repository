<?php

namespace SmashedEgg\LaravelModelRepository\Tests;

use Orchestra\Testbench\TestCase;
use SmashedEgg\LaravelModelRepository\Repository\Repository;
use SmashedEgg\LaravelModelRepository\Repository\RepositoryManager;
use SmashedEgg\LaravelModelRepository\ServiceProvider;
use SmashedEgg\LaravelModelRepository\Tests\Model\User;
use SmashedEgg\LaravelModelRepository\Tests\Repository\UserRepository;

class ServiceProviderTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        config('smashedegg.model_repository', [

            'base_repository' => Repository::class,

            'auto_wire' => true,

            'model_repository_map' => [
                User::class => UserRepository::class,
            ],
        ]);
    }

    public function testServiceProviderRegistersCorrectly()
    {
        $this->assertInstanceOf(RepositoryManager::class, $this->app->make(RepositoryManager::class));
    }
}
