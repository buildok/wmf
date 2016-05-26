<?php

/**
* application config
*/
return [
    'db' => [
        'host' => '',       // hostname
        'scheme' => '',     // db name
        'user' => '',       // username
        'password' => ''    // user password

    ],
    'routes' => [
        '#(?<controller>\w+)/(?<action>\w+)#' => '<controller>/<action>',
    ],
    'defaultRoute' => [
        'controller' => 'app\controllers\UserController',
        'action' => 'index'
    ]
];
