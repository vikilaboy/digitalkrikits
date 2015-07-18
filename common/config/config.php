<?php

return new \Phalcon\Config([
    'database'    => [
        'adapter'  => 'Mysql',
        'host'     => 'localhost',
        'username' => 'digitalkrikits',
        'dbname'   => 'digitalkrikits',
        'password' => '0325it9340ty309',
        'name'     => 'digitalkrikits',
        'schema'   => 'digitalkrikits',
        'charset'  => 'UTF8'
    ],
    'application' => [
        'modelsDir'    => __DIR__ . '/../../common/models/',
        'cacheDir'     => __DIR__ . '/../../frontend/cache/',
        'baseUri'      => '/',
        'baseAdminUri' => '/',
        'cryptSalt'    => 'eEweeweteR|_&G&f,+tU]:jDe!!A&+w1Ms239~8_4I!<@[N@DdaIP_2M|:ew+.u>/6m,$D',
        'view'         => [
            'compiledPath'      => __DIR__ . '/../../cache/volt/',
            'compiledSeparator' => '_',
            'compiledExtension' => '.php',
            'paginator'         => [
                'limit' => 10,
            ],
        ],
    ],
    'models'      => [
        'metadata' => [
            'adapter' => 'Memory'
        ]
    ]
]);
