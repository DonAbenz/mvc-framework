<?php

use Core\Routing\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
   public function test_returns_false_for_non_matching_route()
   {
      $route = new Route('GET', '/path', fn() => 'response');
      $this->assertFalse($route->matches('POST', '/path'));
      $this->assertFalse($route->matches('GET', '/other-path'));
   }

   public function test_returns_true_for_matching_route()
   {
      $route = new Route('GET', '/path', fn() => 'response');
      $this->assertTrue($route->matches('GET', '/path'));
   }

   public function test_returns_false_when_route_does_not_have_parameters()
   {
      $route = new Route('GET', '/path', fn() => 'response');
      $this->assertFalse($route->matches('GET', '/path/1'));
   }

   public function test_returns_true_for_matching_route_with_parameters()
   {
      $route = new Route('GET', '/path/{id}', fn() => 'response');
      $this->assertTrue($route->matches('GET', '/path/1'));
      $this->assertTrue($route->matches('GET', '/path/2'));
   }

   public function test_returns_parameters_for_matching_route_with_parameters()
   {
      $route = new Route('GET', '/path/{id}', fn() => 'response');
      $route->matches('GET', '/path/1');
      $this->assertEquals(['id' => '1'], $route->parameters());
   }

   public function test_returns_parameters_for_matching_route_with_optional_parameters()
   {
      $route = new Route('GET', '/path/{id?}', fn() => 'response');
      $route->matches('GET', '/path');
      $this->assertEquals(['id' => null], $route->parameters());
   }

   public function test_simple_path_match()
   {
      $route = new Route('GET', '/home', fn() => 'response');
      $this->assertTrue($route->matches('GET', '/home'));
   }

   public function test_no_parameters_no_match()
   {
      $route = new Route('GET', '/home', fn() => 'response');
      $this->assertFalse($route->matches('GET', '/home/extra'));
   }
   
   public function test_pattern_match()
   {
      $route = new Route('GET', '/products/view/{product}', fn() => 'response');
      $this->assertTrue($route->matches('GET', '/products/view/123'));
   }
   
   public function test_route_with_parameters()
   {
      $route = new Route('GET', '/products/{id}/view', fn() => 'response');
      $this->assertTrue($route->matches('GET', '/products/1/view'));
      $this->assertEquals(['id' => '1'], $route->parameters());
   }
   
   public function test_route_with_optional_parameters()
   {
      $route = new Route('GET', '/blog/{slug?}', fn() => 'response');
      $this->assertTrue($route->matches('GET', '/blog/hello-world'));
      $this->assertEquals(['slug' => 'hello-world'], $route->parameters());
      
      $this->assertTrue($route->matches('GET', '/blog'));
      $this->assertEquals(['slug' => null], $route->parameters());
   }
   
   public function test_can_add_name_to_route() {
      $route = (new Route('GET', '/home', fn() => 'response'))->name('home');

      $this->assertEquals('home', $route->name());
   }
}
