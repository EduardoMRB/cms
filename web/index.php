<?php
require_once 'bootstrap.php';

use Respect\Config\Container;
use Respect\Rest\Router;
use Users\DataAccess\DataAccess;

$container = new Container(APP_ROOT.'/config/app.ini');
$router = $container->router;


$router->get('/',      'Users\Route\AllUsers', array(
    $container->data
))->accept(array(
    'text/html' => function($data) {
        $html  = '<ul>';
        foreach ($data as $user) {
            $mark = '<li><a href="users/%d">%s<a/></li>';
            $html .= sprintf($mark, $user->id, $user->getName());
        }
        $html .= '</ul>';
        return $html;
    }
));
$router->get('/users', 'Users\Route\AllUsers', array($container->data));
$router->get('/users/*', 'Users\Route\OneUser', array(
    $container->data
))->accept(array(
    'text/html' => function($data) {
        return "<strong>Nome</strong>: {$data['name']}<br/><strong>Email</strong>: {$data['email']}";
    }
));