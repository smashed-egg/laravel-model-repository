<?php

namespace SmashedEgg\LaravelModelRepository\Tests;

use Orchestra\Testbench\TestCase;
use SmashedEgg\LaravelModelRepository\ServiceProvider;

/**
 * @internal
 *
 * @covers \SmashedEgg\LaravelModelRepository\Commands\MakeRepositoryCommand
 */
class MakeRepositoryCommandTest extends TestCase
{
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

    public function testCommandRunsWithFullName(): void
    {
        $this->artisan('smashed-egg:make:repository', [
            'name' => 'UserRepository',
        ])->expectsOutputToContain('created successfully');
    }

    public function testCommandRunsWithFullNameAndShortBaseRepositoryOverride(): void
    {
        $this->artisan('smashed-egg:make:repository', [
            'name' => 'StaffRepository',
            '-B' => CustomRepository::class,
        ])->expectsOutputToContain('created successfully');
    }

    public function testCommandRunsWithFullNameAndBaseRepositoryOverride(): void
    {
        $this->artisan('smashed-egg:make:repository', [
            'name' => 'ProductRepository',
            '--base-repository' => CustomRepository::class,
        ])->expectsOutputToContain('created successfully');
    }

    public function testCommandRunsWithAlias(): void
    {
        $this->artisan('se:make:repository', [
            'name' => 'AccountRepository',
        ])->expectsOutputToContain('created successfully');
    }

    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
        ];
    }
}
