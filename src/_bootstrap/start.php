<?php namespace Acme;

/*
|--------------------------------------------------------------------------
| Replicate CodeIgniter's Constants
|--------------------------------------------------------------------------
| Since index.php isn't run for PHPUNIT, this replaces a
| several of CI's constants
|
*/

$fcpath = str_replace('src'.DIRECTORY_SEPARATOR.'_bootstrap'.DIRECTORY_SEPARATOR.'start.php', '', __FILE__);
$apppath = $fcpath.'application'.DIRECTORY_SEPARATOR;

/*
|--------------------------------------------------------------------------
| Bypass CodeIgniter's CLI Blocker
|--------------------------------------------------------------------------
| CI uses this BASEPATH constant in it's own bootstrap to see if a script
| (such as PHPUNIT) is running. This gets us by that.
|
*/

if ( ! defined('BASEPATH'))
{
    define('BASEPATH', $fcpath.'system'.DIRECTORY_SEPARATOR);
}

/*
|--------------------------------------------------------------------------
| Set Up Your Environment
|--------------------------------------------------------------------------
| If there is an ENVIRONMENT constant, you are Apache or Nginx, carry on.
| If there is no ENVIRONMENT constant, you are probably PHPUNIT,
| head on inside the environment.php file and follow the signs.
|
*/

if (defined('ENVIRONMENT')) {
    $environment = ENVIRONMENT;
} else
{
    include 'environment.php';
}

/*
|--------------------------------------------------------------------------
| Begin Autoloading
|--------------------------------------------------------------------------
| Grabbing the autoloader that Composer made and firing off
| ClassLoader::register() which is auto-autoload. So now we're creating
| classes without the need to keep running `composer dump-autoload`
|
*/

require_once $fcpath.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
\Illuminate\Support\ClassLoader::register();

/*
|--------------------------------------------------------------------------
| Create The IoC Container
|--------------------------------------------------------------------------
| Now we're to the heart of the matter, the IoC container.
|
*/

class Ioc {

    public $ioc;

    public function __construct()
    {
        $this->ioc = new \Illuminate\Container\Container();
        $this->ioc->bind('Ioc', $this->ioc);
        /*
         * Pull in the binding.php
         *
         * Having this means nobody should have to touch the start.php file
         */
        require 'bindings.php';
    }
}

/*
|--------------------------------------------------------------------------
| Set Up Database Connections
|--------------------------------------------------------------------------
| This pulls in the CodeIgniter database settings so we can use them
| with Eloquent in our own Model with the assistance of the Laravel Capsule
|
*/

use Illuminate\Database\Capsule\Manager as Capsule;
$capsule = new Capsule;
$dbPath = (file_exists($apppath.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.$environment.DIRECTORY_SEPARATOR.'database.php') ?
    $apppath.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.$environment.DIRECTORY_SEPARATOR.'database.php' :
    $apppath.'/config/database.php'
);

$db = '';
include $dbPath;

foreach ($db as $dbName => $values)
{
    $capsule->addConnection(array(
            'driver'    => 'mysql',
            'host'      => $values['hostname'],
            'database'  => $values['database'],
            'username'  => $values['username'],
            'password'  => $values['password'],
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => ''
        ),
        $dbName
    );
}

$capsule->setAsGlobal();
$capsule->bootEloquent();
