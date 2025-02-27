<?php

namespace Core\Routing;

use Exception;
use Throwable;

class Router
{
   protected array $routes = [];
   protected Route $current;

   public function add(
      string $method,
      string $path,
      callable $handler
   ): Route {
      $route = $this->routes[] = new Route(
         $method,
         $path,
         $handler
      );
      return $route;
   }

   public function current(): ?Route
   {
      return $this->current;
   }

   public function dispatch()
   {
      $requestPath = $_SERVER['REQUEST_URI'] ?? '/';
      $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

      $matching = $this->match($requestMethod, $requestPath);

      if ($matching) {
         try {
            return $matching->dispatch(); // 🚀 Dispatch the handler
         } catch (Throwable $e) {
            return $this->dispatchError();
         }
      }

      if (in_array($requestPath, $this->paths())) {
         return $this->dispatchNotAllowed();
      }

      return $this->dispatchNotFound();
   }

   public function dispatchError()
   {
      return "server error";
   }

   public function dispatchNotAllowed()
   {
      return "not allowed";
   }

   public function dispatchNotFound()
   {
      return "not found";
   }

   private function match(string $method, string $path): ?Route
   {
      foreach ($this->routes as $route) {
         if ($route->matches($method, $path)) {
            $this->current = $route;
            return $route;
         }
      }

      return null;
   }

   private function paths(): array
   {
      return array_map(fn($route) => $route->path(), $this->routes);
   }

   public function redirect($path)
   {
      header("Location: {$path}", true, 301);
      echo "Redirected to: {$path}"; // ✅ Echo a testable message
      // exit;
   }

   public function route(
      string $name,
      array $parameters = [],
   ): string {
      
      foreach ($this->routes as $route) {
         if ($route->name() === $name) {
            $finds = [];
            $replaces = [];
            foreach ($parameters as $key => $value) {
               // one set for required parameters
               array_push($finds, "{{$key}}");
               array_push($replaces, $value);
               // ...and another for optional parameters
               array_push($finds, "{{$key}?}");
               array_push($replaces, $value);
            }
            $path = $route->path();
            $path = str_replace($finds, $replaces, $path);
            // remove any optional parameters not provided
            $path = preg_replace('#{[^}]+}#', '', $path);
            // we should think about warning if a required
            // parameter hasn't been provided...
            return $path;
         }
      }
      throw new Exception('no route with that name');
   }

   public function routes(): array
   {
      return $this->routes;
   }
}
