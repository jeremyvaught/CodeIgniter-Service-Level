#Service Layer For CodeIgniter using Laravel Components

####Developed for use for [JamPlay.com](http://jamplay.com), a pretty sweet way to learn guitar and/or bass through thousands of awesome video lessons.

######Author Jeremy Vaught

#####Goal of this project:
To create a Service Layer or Application Layer as described by [Ross Tuck](https://github.com/rosstuck)'s video below. Using this, we have begun to refactor our current CodeIgniter MVC (in the classic sense of CI with fat Controllers, models with view code, and visa-versa, etc, you know what I'm talking about) and move the 'app' into a framework agnostic Service Layer. No simple feat but made entirely possible with a couple Laravel components.

I don't intend for this to be an exhaustive reference, more of a quickstart and quick-reference guide. I wrote most of this for us to be used internally, so this is largely meant for us, but since I wrote it down, I'll share, because I like you and you are fun at parties.

For a more details see docs for (make sure you are using docs for v4.1 if you are on PHP 5.3)

* [Eloquent](http://laravel.com/docs/eloquent)
* [IoC Container](http://laravel.com/docs/ioc)
* [PHPUnit](http://phpunit.de/manual/current/en/writing-tests-for-phpunit.html)

Some great video references

* [Laracasts](http://laracasts.com)
  * Pretty much all the stuff on architecture, Dependency Injection, IoC Container, etc
* [Ross Tuck - Models and Service Layers; Hemoglobin and Hobgoblins](http://youtu.be/3uV3ngl1Z8g)
* [Shawn McCool - Laravel.IO, A Use Case Architecture](http://youtu.be/2_380DKU93U)
* [Chris Fidao - Hexagonal Architecture](http://youtu.be/6SBjKOwVq0o)


######Also see [Matt Stauffer's examples of using Laravel compoenents outside of Laravel.](https://github.com/mattstauffer/IlluminateNonLaravel)

## Bindings

Bindings are used in the IoC container to link an interface to a specific usage of that interface. The advantage being, say you are using the transactional email service MailGun, but rather than hardcode that whereever it is used, you have an interface `Mail` and you bind the MailGun class to it `$this->ioc->bind('Mail', 'Acme\Service\Mail\Mailgun');` then in order to  use that service, you call Mail from the IoC container `$this->mail = $this->ioc->make('Mail');`. Then one day, you decide to use SendGrid instead, you simply create the service that uses the Mail interface, and in the binding, change it to `$this->ioc->bind('Mail', 'Acme\Service\Mail\Sendgrid');` and voilà! You are instantly using the new system everywhere you are using `Mail`.

But now say you are using Amazon S3 for some of your data storage, but the rest is local. Instead of hardcoding those all over the place, you have an interface, maybe `db` and you bind your local service to that, but when you want to use the Amazon service instead, you call it directly `$this->db = $this->ioc->make('Acme\Service\Db\Aws');`. But then one day, just like above, you decide to switch to something else entirely, like Google Cloud Storage, you can now call `$this->db = $this->ioc->make('Acme\Service\Db\Gcs');` and you are golden.

All right, that got way wordier than I anticipated. Well, there you go, why we use these things.

### Examples

######CodeIgniter Controllers

In Codeigniter, I haven't figured out how to Inject Dependencies directly into the controllers, so in the __construct(), we need to instantiate the IoC Container by adding 

```
$ioc = new Acme\Ioc;
$this->exampleData  = $ioc->ioc->make('ExampleController');
```

Then to use a service, you would `$this->foo = $this->ioc->make('Acme\:Service\Example\Foo');` or a bound interface `$this->foo = $this->ioc->make('Bar')`

######Service Layer

Classes in the Service Layer itself should have the dependencies injected into the __construct(). Below we are injecting Bar and Baz.

So something like ... 

```

<?php namespace Acme\Services\Example;

class Foo implements FoobooInterface {

    public $bar;
    public $baz;

    public function __construct(Bar $bar, Baz $baz)
    {
        $this->bar = $bar;
        $this->baz = $baz;

    }


```
######Testing

And of course, now we want tests for our code, when we do all the above, our services are fully testable, an example test for the example Foo is as such ...

```
<?php 

use Acme\Ioc;
use Acme\Services\Example\Foo;
use Mockery as M;

class SecondExample extends PHPUnit_Framework_TestCase {

    public $foo;

    public function setUp()
    {
        $ioc = new Ioc;
        $ioc = $ioc->ioc;

        $bar = M::mock($ioc->make('\Acme\Services\Example\Bar'));
        $baz = M::mock($ioc->make('\Acme\Services\Example\Baz'));

        $this->foo = new Foo($bar, $baz);
    }

    public function test_if_foo_is_instantiable()
    {
        $this->assertEquals('Foo is running<hr>', $this->foo->message);
        $this->assertInternalType('string', $this->foo->message);
    }

    public function tearDown()
    {
        M::close();
    }
} 
```
