<?php
namespace Core;

class Router
{
   protected $routes = [];

   public function add($route, $action)
   {
      $this->routes[$route] = $action;
   }

   public function dispatch($url)
   {
      if (!array_key_exists($url, $this->routes)) {
         return "404 - Page Not Found";
      }

      // Extract controller and method
      list($controllerName, $method) = explode('@', $this->routes[$url]);

      // Convert controller name to namespace
      $controllerClass = "\\App\\Controllers\\{$controllerName}";

      // Load the controller dynamically
      if (!class_exists($controllerClass)) {
         die("Controller class not found: {$controllerClass}");
      }

      $controller = new $controllerClass();

      return $controller->$method();
   }
}
