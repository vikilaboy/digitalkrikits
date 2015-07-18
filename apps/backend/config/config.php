<?php

return new \Phalcon\Config(
    array(
        'application' => array(
            'controllersDir' => __DIR__ . '/../controllers/',
            'viewsDir'       => __DIR__ . '/../views/',
            'partialsDir'    => 'partials/',
            'layoutsDir'     => 'layouts',
            'baseUri'        => '/admin/',
            'debug'          => true,
            'view'           => [
                'compiledPath'      => __DIR__ . '/../cache/volt/',
                'compiledSeparator' => '_',
                'compiledExtension' => '.php',
                'viewsDir'          => __DIR__ . '/../views/',
                'paginator'         => [
                    'limit' => 10,
                ],
            ],
            'logger'         => [
                'enabled' => true,
                'path'    => 'log/',
                'format'  => '[%date %][%type %] %message % ',
            ],
            'cache'          => [
                'lifetime' => '86400',
                'prefix'   => 'cache_',
                'adapter'  => 'File',
                'cacheDir' => 'cache/html/',
            ]

        )
    )
);