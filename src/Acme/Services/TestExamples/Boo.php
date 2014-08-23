<?php namespace Acme\Services\TestExamples;

class Boo implements FoobooInterface {

    public $bar;
    public $baz;
    public $message;

    public function __construct(Bar $bar, Baz $baz)
    {
        $this->bar = $bar;
        $this->baz = $baz;
        $this->message = 'Boo is running<hr>';
    }

    public function run()
    {
        //        return 'I.AM.RUNNING';
        return $this->bar->runBar();
    }
}
