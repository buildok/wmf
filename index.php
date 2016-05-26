<?php
ini_set('display_errors', 1);

define('ROOT', dirname(__FILE__));

use app\base\Router;

require(ROOT . '/app/Autoloader.php');

$config = require(ROOT . '/app/config/config.php');

$router = new Router($config['routes'], $config['defaultRoute']);
$router->run();