<?php

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

      // Load the controller dynamically
      require_once __DIR__ . "/../app/controllers/{$controllerName}.php";
      $controller = new $controllerName();

      return $controller->$method();
   }
}
