<?php
use Core\Router;

$router = new Router();
$router->add('/home', 'HomeController@index');

$uri = $_SERVER['REQUEST_URI'] ?? '/';

echo $router->dispatch($uri);
