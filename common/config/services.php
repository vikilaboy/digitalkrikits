<?php

/**
 * Services are globally registered in this file
 */

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\DI\FactoryDefault;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Http\Response\Cookies;
use Phalcon\Crypt;
use Phalcon\Translate\Adapter\Gettextb as Translator;
use Phalcon\Cache\Backend\Memcache;
use Phalcon\Cache\Backend\Libmemcached;
use Phalcon\Mvc\Collection\Manager;
use Phalcon\Cache\Frontend\Data;
use Phalcon\Flash\Session;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Security;
use Phalcon\DI;
use Phalcon\Dispatcher;
use Phalcon\Mvc\Dispatcher as MvcDispatcher,
    Phalcon\Events\Manager as EventsManager,
    Phalcon\Mvc\Dispatcher\Exception as DispatchException;
/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * Register the configuration itself as a service
 */
$di->set('config', include 'config.php', true);

/**
 * Registering a router
 */
$di['router'] = function () {
    return include 'routes.php';
};

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di['url'] = function () {
    $url = new UrlResolver();
    $url->setBaseUri('/');

    return $url;
};


// Start the session the first time some component request the session service
$di->set(
    'session',
    function () {
        $session = new SessionAdapter(
            array(
                'uniqueId' => 'netex'
            )
        );
        $session->start();

        return $session;
    },
    true
);

/**
 * This service controls the initialization of models, keeping record of relations
 * between the different models of the application.
 */
$di->set(
    'collectionManager',
    function () {
        return new Manager();
    }
);

// Register the flash service with custom CSS classes
$di->set(
    'flashSession',
    function () {
        $flash = new Session(
            array(
                'error'   => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice'  => 'alert alert-info',
            )
        );

        return $flash;
    }
);

// Database connection is created based in the parameters defined in the configuration file
$di->set(
    'db',
    function () use ($di) {
        return new Mysql(
            [
                'host'     => $di->get('config')->database->host,
                'username' => $di->get('config')->database->username,
                'password' => $di->get('config')->database->password,
                'dbname'   => $di->get('config')->database->dbname,
                'schema'   => $di->get('config')->database->schema,
                'options'  => array(
                    \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $di->get('config')->database->charset
                )
            ]
        );
    },
    true // shared
);

$di->set(
    'cookies',
    function () {
        $cookies = new Cookies();

        return $cookies;
    },
    true
);

$di->set(
    'crypt',
    function () use ($di) {
        $crypt = new Crypt();
        $crypt->setKey($di->get('config')->application->cryptSalt); //Use your own key!

        return $crypt;
    }
);

$di->set(
    'security',
    function () {

        $security = new Security();

        //Set the password hashing factor to 12 rounds
        $security->setWorkFactor(12);

        return $security;
    },
    true
);

//Set the models cache service
$di->set(
    'modelsCache',
    function () {

        //Cache data for one day by default
        $frontCache = new Data(
            array(
                "lifetime" => 86400
            )
        );

        //Memcached connection settings
        $cache = new Memcache(
            $frontCache, array(
                "host" => "localhost",
                "port" => "11211"
            )
        );

        return $cache;
    }
);

$di->set('dispatcher', function () use ($di) {

    //Create an EventsManager
    $eventsManager = new EventsManager();

    //Attach a listener
    $eventsManager->attach("dispatch:beforeException", function ($event, $dispatcher, $exception) use ($di) {
        //Handle 404
        switch ($exception->getCode()) {
            case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
            case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                $dispatcher->forward([
                    'controller' => 'index',
                    'action' => 'show404'
                ]);

                return false;
        }
    });

    $dispatcher = new \Phalcon\Mvc\Dispatcher();

    //Bind the EventsManager to the dispatcher
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;

}, true);
