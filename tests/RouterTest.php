<?php

use PHPUnit\Framework\TestCase;

require_once "./core/Router.php";
require_once "./app/controllers/HomeController.php";

class RouterTest extends TestCase
{
   public function test_dispatch_returns_404()
   {
      $router = new Router();
      $this->assertEquals("404 - Page Not Found", $router->dispatch('/unknown'));
   }

   public function test_can_add_route()
   {
      $router = new Router();
      $router->add('/home', 'HomeController@index');

      $this->assertEquals("200 OK", $router->dispatch('/home'));
   }
}
