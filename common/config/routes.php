<?php

use Phalcon\Mvc\Router;

$router = new Router();

//Remove trailing slashes automatically
$router->removeExtraSlashes(true);

$router->setDefaultModule("backend");
$router->setDefaultNamespace("DigitalKrikits\Backend\Controllers");


return $router;