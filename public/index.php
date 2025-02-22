<?php

const BASE_PATH = __DIR__ . '/../';

require_once BASE_PATH . "core/Router.php";

$router = new Router();
$router->add('/home', 'app/views/home.php');

$uri = $_SERVER['REQUEST_URI'];

echo $router->dispatch($uri);

function dd($value)
{
   echo "<pre>";
   var_dump($value);
   echo "</pre>";

   die();
}
