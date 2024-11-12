<?php

namespace SmashedEgg\LaravelModelRepository\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Arr;
use SmashedEgg\LaravelModelRepository\Repository\Repository;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeRepositoryCommand extends GeneratorCommand
{
    protected $name = 'smashed-egg:make:repository';

    protected string $defaultBaseRepository = Repository::class;

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    protected function configure()
    {
        parent::configure();

        $this->setAliases([
            'se:make:repository',
        ]);
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        if ( ! is_dir(app_path('Repositories'))) {
            mkdir(app_path('Repositories'));
        }

        return is_dir(app_path('Repositories')) ? $rootNamespace.'\Repositories' : $rootNamespace;
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param string $stub
     */
    protected function resolveStubPath($stub): string
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.$stub;
    }

    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/repository.stub');
    }

    protected function buildClass($name): string
    {
        $stub = parent::buildClass($name);

        /** @var string $baseRepositoryFQNSClass */
        $baseRepositoryFQNSClass = $this->option('base-repository');

        /** @var string $baseRepositoryClass */
        $baseRepositoryClass = Arr::last(explode('\\', $baseRepositoryFQNSClass));

        // Replace namespace of repository
        $stub = str_replace(
            '{{ baseRepository }}',
            $baseRepositoryFQNSClass,
            $stub
        );

        // Replace class of repository
        return str_replace(
            '{{ baseRepositoryClass }}',
            $baseRepositoryClass,
            $stub
        );
    }

    /**
     * @return list<mixed>
     */
    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the class'],
        ];
    }

    /**
     * @return list<mixed>
     */
    protected function getOptions(): array
    {
        return [
            [
                'base-repository',
                '-B',
                InputOption::VALUE_OPTIONAL,
                'The name of the base repository class to extend.',
                config('smashedegg.model_repository.base_repository', $this->defaultBaseRepository),
            ],
        ];
    }
}
