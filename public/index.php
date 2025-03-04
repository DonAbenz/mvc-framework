<?php
const BASE_PATH = __DIR__ . '/../';

require_once BASE_PATH . 'vendor/autoload.php';

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

$router = new Core\Routing\Router();

$routes = require_once BASE_PATH . 'app/routes.php';
$routes($router);

print $router->dispatch();
