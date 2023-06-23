<?php

namespace SmashedEgg\LaravelModelRepository\Tests;

use Orchestra\Testbench\TestCase;
use SmashedEgg\LaravelModelRepository\ServiceProvider;

class MakeRepositoryCommandTest extends TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();

        if (file_exists(app_path('Repositories/UserRepository.php'))) {
            unlink(app_path('Repositories/UserRepository.php'));
        }
        if (file_exists(app_path('Repositories/AccountRepository.php'))) {
            unlink(app_path('Repositories/AccountRepository.php'));
        }
    }

    public function testCommandRunsWithFullName()
    {
        $this->artisan('smashed-egg:make:repository', [
            'name' => 'UserRepository'
        ])->expectsOutputToContain('created successfully');
    }

    public function testCommandRunsWithAlias()
    {
        $this->artisan('se:make:repository', [
            'name' => 'AccountRepository'
        ])->expectsOutputToContain('created successfully');
    }

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }
}
