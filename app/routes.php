<?php

use Core\Routing\Router;

return function (Router $router) {
   $router->add('GET', '/', fn() => "Hello World");
   $router->add('GET', '/old-home', fn() => $router->redirect('/'));

   $router->add('GET', '/has-server-error', fn() => throw new Exception());
   $router->add('GET', '/has-validation-error', fn() => $router->dispatchNotAllowed());
};
