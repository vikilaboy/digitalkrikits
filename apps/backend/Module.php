<?php

namespace DigitalKrikits\Backend;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Mvc\Url;
use Phalcon\Events\Manager as EventsManager;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(\Phalcon\DiInterface $dependencyInjector = null)
    {
        $loader = new \Phalcon\Loader();

        $loader->registerNamespaces([
            'DigitalKrikits\Backend\Controllers' => __DIR__ . '/controllers/',
            'DigitalKrikits\Backend\Forms'       => __DIR__ . '/forms/',
            'DigitalKrikits\Models'              => __DIR__ . '/../../common/models/'
        ]);

        $loader->register();
    }

    /**
     * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
     */
    public function registerServices(\Phalcon\DiInterface $di)
    {
        /**
         * Read configuration
         */
        $config = include __DIR__ . "/config/config.php";

        /**
         * Setting up the view component
         */
        // The URL component is used to generate all kind of urls in the application
        $di->set('url', function () {
            $url = new Url();
            $url->setBaseUri('/');
            return $url;
        });

        /**
         * Setting up the view component
         */
        $di->set(
            'view',
            function () use ($config) {
                $view = new View();
                $view->setViewsDir($config->application->view->viewsDir);
                $view->disableLevel([View::LEVEL_MAIN_LAYOUT => true, View::LEVEL_LAYOUT => true]);
                $view->registerEngines(
                    [
                        '.volt' => function () use ($view, $config) {
                            $volt = new Volt($view);
                            $volt->setOptions(
                                [
                                    'compiledPath'      => $config->application->view->compiledPath,
                                    'compiledSeparator' => $config->application->view->compiledSeparator,
                                    'compiledExtension' => $config->application->view->compiledExtension,
                                    'compileAlways'     => true,
                                ]
                            );
                            return $volt;
                        }
                    ]
                );

                // Create an event manager
                $eventsManager = new EventsManager();

                // Attach a listener for type 'view'
                $eventsManager->attach(
                    'view',
                    function ($event, $view) {
                        if ($event->getType() == 'notFoundView') {
                            throw new \Exception('View not found!!! (' . $view->getActiveRenderPath() . ')');
                        }
                    }
                );

                // Bind the eventsManager to the view component
                $view->setEventsManager($eventsManager);

                return $view;
            }
        );
    }
}