<?php namespace Acme\Services\TestExamples;

class Foo implements FoobooInterface {

    public $bar;
    public $baz;
    public $nextLevelFoo;
    public $message;

    public function __construct(Bar $bar, Baz $baz, Foozar $nextLevelFoo)
    {
        $this->bar = $bar;
        $this->baz = $baz;
        $this->nextLevelFoo = $nextLevelFoo;

        $this->message = 'Foo is running<hr>';
    }

    public function run()
    {
        return $this->bar->runBar();
    }

    public function playaDos()
    {
        return $this->nextLevelFoo->vamos();
    }
}
