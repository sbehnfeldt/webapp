<?php

namespace Sbehnfeldt\Webapp;

require_once '../vendor/autoload.php';

function bootstrap(string $configFile = '../config.json')
{
    if (!file_exists('../logs')) {
        if (!mkdir('../logs')) {
            die('Cannot make log directory');
        }
    }
    ini_set('error_log', '../logs/php_errors.log');


    if ( ! file_exists('../sessions')) {
        if ( ! mkdir('../sessions')) {
            die('Cannot make sessions directory');
        }
    }
    session_save_path('../sessions');
    if (!session_start()) {
        die('Cannot start session');
    }

    if ( false == ($config = json_decode(file_get_contents($configFile), true))) {
        die(sprintf('Unable to parse config file "%s"', $configFile));
    }
    ini_set('display_errors', 'Off');

    return $config;
}
