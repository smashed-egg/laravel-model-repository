<p align="center">
  <img src="https://raw.githubusercontent.com/smashed-egg/.github/05d922c99f1a3bddea88339064534566b941eca9/profile/main.jpg" width="300">
</p>

# Laravel Model Repository

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
## Usage

### Create Repository

You can run the following command to create a new Repository for your Model, assuming you already have a User model:

```
php artisan smashed-egg:make:repository UserRepository
```

or using the command alias:

```
php artisan se:make:repository UserRepository
```

Out of the box you get access to the following methods, that will pass along to the Model instance:

- save(Model $model)
- delete(Model $model, bool $force = false) - When using the SoftDeletes trait you can control whether you want to soft or hard delete
- restore(Model $model) - When using the SoftDeletes trait you can undo a soft deletion
- query - Start an eloquent query
- baseQuery - Start a database query