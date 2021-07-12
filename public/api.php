<?php

namespace Sbehnfeldt\Webapp;


use Slim\Container;
use Throwable;

require '../lib/bootstrap.php';
$config = bootstrap();

$dependencies = new Container([
    'settings' => $config
]);

$web = new ApiApp($dependencies);
try {
    $web->run();

} catch (Throwable $t) {
    die( "Error" );
}

