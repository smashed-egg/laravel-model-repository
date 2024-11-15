<?php

use SmashedEgg\LaravelModelRepository\Repository\AbstractRepository;

return [
    // The base Repository Class to use for all Repositories generated via cli
    'base_repository' => AbstractRepository::class,

    'auto_wire' => true,

    /*
     * Map of Models to Repository classes
     *
     * Useful when using the RepositoryManager class
     */
    'model_repository_map' => [
        // \App\Models\User::class => \App\Repositories\UserRepository::class,
    ],
];
