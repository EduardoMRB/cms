<?php
require_once 'bootstrap.php';

use Respect\Config\Container;
use Respect\Rest\Router;
use Users\DataAccess\DataAccess;

$container = new Container(APP_ROOT.'/config/app.ini');
$router = $container->router;


$router->get('/',      'Users\Route\AllUsers', array($container->data));
$router->get('/users', 'Users\Route\AllUsers', array($container->data));