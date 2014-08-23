<?php namespace Acme\Services\TestExamples;

class Bar {

    public $bazzar;
    public $message;

    public function __construct(Bazzar $bazzar)
    {
        $this->message = 'found Bar<hr>';
        $this->bazzar = $bazzar;
    }

    public function runBar()
    {
        return 'Bar is running';
    }
}
