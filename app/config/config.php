<?php

/**
* application config
*/
return [
    'db' => [
        'host' => 'localhost',
        // 'scheme' => 'wmf_zzz_com_ua',
        // 'user' => 'buildok01',
        // 'password' => '9308564'
        'scheme' => 'wmf',
        'user' => 'root',
        'password' => '9308564'
    ],
    'routes' => [
        '#(?<controller>\w+)/(?<action>\w+)#' => '<controller>/<action>',
    ],
    'defaultRoute' => [
        'controller' => 'app\controllers\UserController',
        'action' => 'index'
    ]
];
