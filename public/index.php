<?php

use Phalcon\Mvc\Application;

error_reporting(E_ALL);
// Set internal character encoding to UTF-8.
if (function_exists('mb_internal_encoding')) {
    mb_internal_encoding('UTF-8');
}
setlocale(LC_TIME, 'ro_RO.UTF-8');

//  Global constants
define('PS', PATH_SEPARATOR);               // Path separator
define('DS', DIRECTORY_SEPARATOR);          // Directory separator
define('PUBLIC_DIR', __DIR__ . DS);         // Public absolute folder
define('ROOT_DIR', dirname(__DIR__) . DS);  // Root absolute folder
define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'dev'));
define('APPS_DIR', ROOT_DIR . 'apps' . DS);
define('VENDOR_DIR', ROOT_DIR . 'vendor' . DS);

define('PROJECT_BASE_NAMESPACE', 'DigitalKrikits');

//  Phalcon Debugger
(new Phalcon\Debug)->listen();

try {

    /**
    * Include services
    */
    require __DIR__ . '/../common/config/services.php';

    /**
     * Handle the request
     */
    $application = new Application();

    /**
     * Assign the DI
     */
    $application->setDI($di);

    /**
     * Include modules
     */
    $application->registerModules(require __DIR__ . '/../common/config/modules.php');

    echo $application->handle()->getContent();

} catch (Phalcon\Exception $e) {
    echo $e->getMessage();
} catch (PDOException $e){
    echo $e->getMessage();
}

function d($object, $kill = true)
{
    echo '<pre style="text-aling:left">';
    print_r($object);
    if ($kill) {
        die('END');
    }
    echo '</pre>';
}
