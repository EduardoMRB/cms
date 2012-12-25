<?php
require_once 'bootstrap.php';

use Respect\Rest\Router;
use Users\DataAccess\DataAccess;

$pdo = new PDO('mysql:host=localhost;dbname=cms', 'root', 'asdzxc');
$router = new Router();

$router->get('/', 'Users\Route\AllUsers', array(new DataAccess($pdo)));