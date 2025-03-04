<?php

use Core\Routing\Route;
use PHPUnit\Framework\TestCase;

use Core\Routing\Router;

class RouterTest extends TestCase
{
   protected $router;

   protected function setUp(): void
   {
      $this->router = new Router();
   }

   private function sendRequest($method = 'GET', $path = '/home')
   {
      $_SERVER['REQUEST_URI'] = $path;
      $_SERVER['REQUEST_METHOD'] = $method;
   }

   public function test_add_route_successfully()
   {
      $this->router->add('GET', '/home', function () {});

      $this->assertTrue(($this->router->routes()[0] instanceof Route));
      $this->assertNotEmpty($this->router->routes());
      $this->assertCount(1, $this->router->routes());
      $this->assertEquals('GET', $this->router->routes()[0]->method());
      $this->assertEquals('/home', $this->router->routes()[0]->path());
      $this->assertIsCallable($this->router->routes()[0]->handler());
   }

   public function test_dispatch_returns_redirect_for_mapped_uri()
   {
      $this->router->add('GET', '/home', fn() => "Hello World");
      $this->router->add('GET', '/old-home', fn() => $this->router->redirect('/home'));

      $this->sendRequest();
      $response = $this->router->dispatch();
      $this->assertEquals("Hello World", $response);

      $this->sendRequest(path: '/old-home');

      // ✅ Capture output since `redirect()` echoes
      ob_start();
      $this->router->dispatch();
      $output = ob_get_clean();

      $this->assertEquals("Redirected to: /home", trim($output));
   }

   public function test_dispatch_returns_expected_response_for_existing_route()
   {
      $this->router->add('GET', '/home', fn() => "Hello World");

      $this->sendRequest();
      $response = $this->router->dispatch();

      $this->assertEquals("Hello World", $response);
   }

   public function test_dispatch_returns_not_found_for_unmapped_route()
   {
      $this->sendRequest();
      $this->assertEquals("not found", $this->router->dispatch());
   }

   public function test_dispatch_returns_not_allowed_for_invalid_http_method()
   {
      $this->router->add('GET', '/home', fn() => "Hello World");

      $this->sendRequest(method: 'POST');
      $response = $this->router->dispatch();

      $this->assertEquals("not allowed", $response);
   }

   public function test_dispatch_handles_server_error_gracefully()
   {
      $route = $this->router->add('GET', '/home', function () {
         throw new Exception();
         return "Hello World";
      });

      $this->sendRequest(method: 'GET', path: $route->path());

      $response = '';
      try {
         $response = $this->router->dispatch();
      } catch (\Throwable $th) {
         $this->assertEquals("server error", $response);
      }

      $this->fail('No error response detected');
   }

   public function test_can_build_url_using_named_route()
   {
      $this->router->add('GET', '/products/{page?}', fn() => $this->router->current()->parameters())->name('product-list');
      $accessName = 'product-list';

      try {
         $path = $this->router->route($accessName);
         $this->sendRequest(method: 'GET', path: $path);
         $response = $this->router->dispatch();

         $this->assertEquals('/products/', $path);
         $this->assertNotEmpty($response);
      } catch (\Throwable $th) {
         $this->assertEquals('no route with that name', $th->getMessage());
         $this->fail('no route with the name ' . $accessName);
      }
   }

   public function test_can_build_url_using_named_route_with_parameters()
   {
      $this->router->add('GET', '/products/{page?}', fn() => $this->router->current()->parameters())->name('product-list');
      $accessName = 'product-list';

      $path = $this->router->route($accessName, ['page' => 1]);
      $this->sendRequest(method: 'GET', path: $path);
      $response = $this->router->dispatch();

      $this->assertEquals('/products/1', $path);
      $this->assertNotEmpty($response);
      $this->assertArrayHasKey('page', $response);
      $this->assertEquals('1', $response['page']);
   }

   public function test_can_build_url_using_named_route_without_parameters()
   {
      $this->router->add('GET', '/products/{page?}', fn() => $this->router->current()->parameters())->name('product-list');
      $accessName = 'product-list';

      $path = $this->router->route($accessName);
      $this->sendRequest(method: 'GET', path: $path);
      $response = $this->router->dispatch();

      $this->assertEquals("/products/", $path);
      $this->assertArrayHasKey('page', $response);
      $this->assertEmpty($response['page']);
   }
}
