<?php

use App\Http\Controllers\ListProductsController;
use App\Http\Controllers\ShowHomeController;
use App\Http\Controllers\Users\RegisterUserController;
use App\Http\Controllers\Users\ShowRegisterFormController;
use Core\Routing\Router;

return function (Router $router) {
   $router->add('GET', '/', [ShowHomeController::class, 'handle']);
   $router->add('GET', '/old-home', fn() => $router->redirect('/'));
   $router->add('GET', '/has-server-error', fn() => throw new Exception());
   $router->add('GET', '/has-validation-error', fn() => $router->dispatchNotAllowed());

   $router->add(
      'GET',
      '/products/view/{product}',
      function () use ($router) {
         $parameters = $router->current()->parameters();
         return view('products/view', [
            'product' => $parameters['product'],
            'scary' => '<script>alert("boo!")</script>',
         ]);
      },
   );

   $router->add(
      'GET',
      '/products/list',
      [new ListProductsController($router), 'handle'],
   )->name('list-products');

   $router->add(
      'GET',
      '/services/view/{service?}',
      function () use ($router) {
         $parameters = $router->current()->parameters();
         if (empty($parameters['service'])) {
            return 'all services';
         }
         return "service is {$parameters['service']}";
      },
   );

   $router->add(
      'GET',
      '/products/{page?}',
      function () use ($router) {
         $parameters = $router->current()->parameters();
         $parameters['page'] ??= 1;
         return "products for page {$parameters['page']}";
      },
   )->name('product-list');

   $router->add(
      'GET',
      '/register',
      [new ShowRegisterFormController($router), 'handle'],
   )->name('show-register-form');

   $router->add(
      'POST',
      '/register',
      [new RegisterUserController($router), 'handle'],
   )->name('register-user');
};
