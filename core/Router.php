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

      return "200 OK";
   }
}
