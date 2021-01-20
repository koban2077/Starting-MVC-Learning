<?php

use App\Utils\Config;
use App\Utils\Router;

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';
//require __DIR__ . '/../helpers.php';

$router = new Router();
$router->process();