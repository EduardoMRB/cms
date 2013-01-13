<?php
require_once 'bootstrap.php';

use Respect\Config\Container;
use Respect\Rest\Router;
use Users\DataAccess\DataAccess;

$container = new Container(APP_ROOT.'/config/app.ini');
$router = $container->router;


$router->get('/users', 'Users\Route\AllUsers', array(
    $container->data
))->accept(array(
    'text/html' => function($data) {
        $html  = '<ul>';
        foreach ($data as $user) {
            $mark = '<li><a href="users/%d">%s<a/></li>';
            $html .= sprintf($mark, $user->id, $user->getName());
        }
        $html .= '</ul>';
        $html .= '
            <form method="POST">
            <input type="text" name="name" placeholder="Nome" required="required">
            <br>
            <input type="email" name="email" placeholder="Email" required="required">
            <br>
            <input type="password" name="password" placeholder="Senha" required="required">
            <input type="submit" value="Novo usuario">
            </form>
        ';
        return $html;
    }
));

$router->get('/users/*', 'Users\Route\OneUser', array(
    $container->data,
    $container->app,
))->accept(array(
    'text/html' => function($data) {
        return "<strong>Nome</strong>: {$data['name']}<br/><strong>Email</strong>: {$data['email']}";
    }
));

$router->post('/users', 'Users\Route\OneUser', array(
    $container->data, $container->app
))->accept(array(
    'text/html' => function() {
        $html = '<a href="%s/users">Voltar para a lista</a>';
        return sprintf($html, APP_URL);
    }
));

$router->exceptionRoute('RuntimeException', function(\RuntimeException $e) {
    echo 'Oops, ocorreu um erro: '.$e->getMessage();
});