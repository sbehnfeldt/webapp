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

    $host = $config['propel']['host'];
    $dbname = $config['propel']['dbname'];
    $user = $config['propel']['uname'];
    $password = $config['propel']['pword'];

    $serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
    $serviceContainer->checkVersion(2);
    $serviceContainer->setAdapterClass('webapp', 'mysql');
    $manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
    $manager->setConfiguration(array(
        'classname' => 'Propel\\Runtime\\Connection\\ConnectionWrapper',
        'dsn' => "mysql:host=$host;dbname=$dbname",
        'user' => $user,
        'password' => $password,
        'attributes' =>
            array(
                'ATTR_EMULATE_PREPARES' => false,
                'ATTR_TIMEOUT' => 30,
            ),
        'model_paths' =>
            array(
                0 => 'src',
                1 => 'vendor',
            ),
    ));
    $manager->setName('attend');
    $serviceContainer->setConnectionManager('webapp', $manager);
    $serviceContainer->setDefaultDatasource('webapp');

    $serviceContainer->initDatabaseMaps(array (
        'webapp' =>
            array (
                0 => '\\Sbehnfeldt\\Webapp\\PropelDbEngine\\Map\\UserTableMap',
            ),
    ));
    return $config;
}
