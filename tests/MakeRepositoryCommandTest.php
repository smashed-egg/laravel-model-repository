<?php

use Orchestra\Testbench\TestCase;

class MakeRepositoryCommandTest extends TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();

        /*if (file_exists(app_path('Repositories/UserRepository.php'))) {
            unlink(app_path('Repositories/UserRepository.php'));
        }
        if (file_exists(app_path('Repositories/AccountRepository.php'))) {
            unlink(app_path('Repositories/AccountRepository.php'));
        }*/
    }

    public function testCommand()
    {
        $this->artisan('smashed-egg:make:repository', [
            'name' => 'UserRepository'
        ])->expectsOutputToContain('created successfully');
    }

    public function testCommand2()
    {
        $this->artisan('se:make:repository', [
            'name' => 'AccountRepository'
        ])->expectsOutputToContain('created successfully');
    }

    protected function getPackageProviders($app)
    {
        return [
            \SmashedEgg\LaravelModelRepository\ServiceProvider::class,
        ];
    }
}
