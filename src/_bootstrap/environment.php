<?php

/*
|--------------------------------------------------------------------------
| Set Up Your Environment Part Two
|--------------------------------------------------------------------------
| PHPUNIT can't get $_SERVER variables, they are through the web server.
| So, I'm gonna need to fake the environment to replicate CI_ENV
|
| Add your hostname to this little $environmentConverter array below
| (you can get your hostname from BASH by typing `hostname`)
| or possibly in the error statement that brought you here
|
| Example: 'your-hostname' => 'your-environment',
|
*/

$environmentConverter = array(
    'jeremys-air'               => 'vaught', // Jeremy's macbook standard name
    'Jeremys-MacBook-Air.local' => 'vaught', // Jeremy's macbook on other wifis
    'vaught'                    => 'vaught', // Jeremy's vagrant with hostname set
    'your-hostname'             => 'your-environment', // Example
);

/*
|--------------------------------------------------------------------------
| Complete Setting Up The Environment Variable
|--------------------------------------------------------------------------
| If the hostname is in the array above set the corresponding environment
| to the variable, else tell them they are doing it wrong and bring them
| here with a friendly message so they can resolve
|
*/

$inEnvironmentConverter = NULL;
foreach ($environmentConverter as $key => $value)
{
    if (gethostname() == $key)
    {
        $inEnvironmentConverter = $value;
    }
}


if ( $inEnvironmentConverter == NULL)
{
    echo PHP_EOL.PHP_EOL;
    echo 'Your environment is not set up for PHPUNIT';
    echo PHP_EOL.PHP_EOL;
    echo 'Please update the hostname-to-environment converter located at '.__FILE__;
    echo PHP_EOL.PHP_EOL;
    echo 'Your hostname is '.gethostname();
    echo PHP_EOL.PHP_EOL;
    echo 'Thanks,'.PHP_EOL.'Management'.PHP_EOL;
    die();
} else {
    $environment = $inEnvironmentConverter;
}
