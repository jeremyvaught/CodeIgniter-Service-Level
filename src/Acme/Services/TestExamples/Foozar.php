<?php namespace Acme\Services\TestExamples;

class Foozar implements SecondInterface {

    public $message;

    public function __construct()
    {
        $this->message = 'found Foozar<hr>';
    }

    public function playa()
    {
        return 'Foozar playa big time';
    }
    public function vamos()
    {
        return 'Foozar vamos a la playa';
    }
} 
