<?php
require_once BASE_PATH . "core/Router.php";

$router = new Router();
$router->add('/home', 'HomeController@index');

$uri = $_SERVER['REQUEST_URI'];

echo $router->dispatch($uri) ?? '/';