<?php

namespace SmashedEgg\LaravelModelRepository\Tests;

use Orchestra\Testbench\TestCase;
use SmashedEgg\LaravelModelRepository\ServiceProvider;

class MakeRepositoryCommandTest extends TestCase
{
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

    public function testCommandRunsWithFullName()
    {
        $this->artisan('smashed-egg:make:repository', [
            'name' => 'UserRepository'
        ])->expectsOutputToContain('created successfully');
    }

    public function testCommandRunsWithFullNameAndShortBaseRepostioryOverride()
    {
        $this->artisan('smashed-egg:make:repository', [
            'name' => 'StaffRepository',
            '-B' => CustomRepository::class,
        ])->expectsOutputToContain('created successfully');
    }

    public function testCommandRunsWithFullNameAndBaseRepostioryOverride()
    {
        $this->artisan('smashed-egg:make:repository', [
            'name' => 'ProductRepository',
            '--base-repository' => CustomRepository::class,
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
