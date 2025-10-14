# Repository Pattern for Laravel

A Laravel package that implements the Repository Pattern to provide a clean separation between your business logic and data access layers.

## Installation

Install the package via Composer:

```bash
composer require rez1pro/laravel-repository-pattern
```

## Configuration

### Register the Service Provider

Add the service provider to your `bootstrap/app.php` file:

```php
return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        \Rez1pro\RepositoryPattern\RepositoryServiceProvider::class,
    ])
    // ...existing code...
```

For Laravel versions < 11, add to `config/app.php`:

```php
'providers' => [
    // ...existing providers...
    \Rez1pro\RepositoryPattern\RepositoryServiceProvider::class,
],
```

## Usage

### Artisan Commands

This package provides convenient Artisan commands to generate repository classes and interfaces:

#### Generate a Repository Class

```bash
php artisan make:repo {RepositoryName}
```

Example:
```bash
php artisan make:repo UserRepository
```

#### Generate a Repository Interface

```bash
php artisan make:interface {InterfaceName}
```

Example:
```bash
php artisan make:interface UserRepositoryInterface
```

## Features

- Clean separation of concerns
- Easy-to-use Artisan commands
- Follows Laravel conventions
- Improves testability and maintainability

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

## Support

For issues, questions, or contributions, please visit the [GitHub repository](https://github.com/rez1pro/repository-pattern).
