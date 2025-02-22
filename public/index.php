<?php

const BASE_PATH = __DIR__ . '/../';

require_once BASE_PATH . "core/Router.php";

$router = new Router();
$router->add('/home', 'HomeController@index');

$uri = $_SERVER['REQUEST_URI'];

$router->dispatch($uri);

function dd($value)
{
   echo "<pre>";
   var_dump($value);
   echo "</pre>";

   die();
}
