<?php

/*
|--------------------------------------------------------------------------
| Bindings For The IoC Container
|--------------------------------------------------------------------------
| Example: $this->ioc->bind('FooInterface', 'Jamplay\Services\Example\Foo');
|
| More usage examples in the readme
*/

$this->ioc->bind('ExampleController', 'Acme\Controllers\ExampleController');

/*
 * Services Other
 */

/*
 * Repositories
 */

// Eloquent
$this->ioc->bind('Acme\Repositories\Homestead\UsersRepositoryInterface',  'Acme\Repositories\Homestead\EloquentUsersRepository');

/*
 * Some additional classes to run through PHPUnit
 */
$this->ioc->bind('Acme\Services\TestExamples\FooInterface', 'Acme\Services\TestExamples\Foo');
$this->ioc->bind('Bar', 'Acme\Services\TestExamples\Bar');
