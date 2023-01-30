<?php

namespace SmashedEgg\LaravelModelRepository\Console;

use Illuminate\Console\GeneratorCommand;

class MakeRepositoryCommand extends GeneratorCommand
{
    protected $name = 'smashed-egg:make:repository';

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
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        if ( ! is_dir(app_path('Repositories'))) {
            mkdir(app_path('Repositories'));
        }

        return is_dir(app_path('Repositories')) ? $rootNamespace.'\\Repositories' : $rootNamespace;
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.$stub;
    }

    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/repository.stub');
    }
}
