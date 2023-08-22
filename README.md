<p align="center">
  <img src="https://raw.githubusercontent.com/smashed-egg/.github/05d922c99f1a3bddea88339064534566b941eca9/profile/main.jpg" width="300">
</p>

# Laravel Model Repository 
[![Latest Stable Version](https://poser.pugx.org/smashed-egg/laravel-model-repository/v/stable)](https://github.com/smashed-egg/laravel-model-repository/releases) 
[![Downloads this Month](https://img.shields.io/packagist/dm/smashed-egg/laravel-model-repository.svg)](https://packagist.org/packages/smashed-egg/laravel-model-repository)

This package provides a Repository class for people who like SOLID principles (Separation of concerns and all that jazz) 
and want their repository logic in a different class. 

## Requirements

* PHP 8.0.2+
* Laravel 9.0+

## Installation

To install this package please run:

```
composer require smashed-egg/laravel-model-repository
```

You can publish a configuration file that comes with the package:

```
php artisan vendor:publish --provider="SmashedEgg\LaravelModelRepository\ServiceProvider"
```

## Usage

### Configuration (optional)

If you have published the config file (located at config/smashedegg/model_repository.php) 
you can override the base repository class used with the make command, as well as a model to repository mapping, 
which is useful when using the RepositoryManager class (more on that later).

```php
<?php

return [

    /**
     * The base Repository Class to use for all Repositories generated via cli
     */
    'base_repository' => \SmashedEgg\LaravelModelRepository\Repository\Repository::class,

    /**
     * Map of Models to Repository classes
     *
     * Useful when using the RepositoryManager class
     */
    'model_repository_map' => [
        //\App\Models\User::class => \App\Repositories\UserRepository::class,
    ],
];
```

### Creating a Model Repository

You can run the following command to create a new Repository for your Model, assuming you already have a User model:

```
php artisan smashed-egg:make:repository UserRepository
```

or using the command alias:

```
php artisan se:make:repository UserRepository
```

You can even override the base repository class

```
php artisan se:make:repository UserRepository --base-repository="App\Repositories\CustomRepository"
```

Out of the box you get access to the following methods, that will pass along to the Model instance:

- save(Model $model)
- delete(Model $model, bool $force = false) - When using the SoftDeletes trait you can control whether you want to soft or hard delete
- restore(Model $model) - When using the SoftDeletes trait you can undo a soft deletion
- query - Start an eloquent query
- baseQuery - Start a database query

### Using the RepositoryManager

If you have configured a model to repository mapping
