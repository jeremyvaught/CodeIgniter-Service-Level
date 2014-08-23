<?php

use Acme\Ioc;
use Acme\Services\TestExamples\Foo;
use Mockery as M;

class SecondExampleTest extends PHPUnit_Framework_TestCase {

    public $foo;

    public function setUp()
    {
        $ioc = new Ioc;
        $ioc = $ioc->ioc;

        $bar = M::mock($ioc->make('\Acme\Services\TestExamples\Bar'));
        $baz = M::mock($ioc->make('\Acme\Services\TestExamples\Baz'));
        $foozar = M::mock($ioc->make('\Acme\Services\TestExamples\Foozar'));

        $this->foo = new Foo($bar, $baz, $foozar);
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
