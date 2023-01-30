<?php

use Orchestra\Testbench\TestCase;

class MakeRepositoryCommandTest extends TestCase
{
    /**
     * Get Application base path.
     *
     * @return string
     */
    public static function applicationBasePathss()
    {
        return __DIR__.'/../';
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
