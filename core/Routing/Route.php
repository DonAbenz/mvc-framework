<?php

namespace Core\Routing;

class Route
{
   protected string $method;
   protected string $path;
   protected $handler;

   protected array $parameters = [];

   public function __construct(
      string $method,
      string $path,
      callable $handler
   ) {
      $this->method = $method;
      $this->path = $path;
      $this->handler = $handler;
   }

   public function dispatch()
   {
      return call_user_func($this->handler);;
   }

   public function handler(): callable
   {
      return $this->handler;
   }

   public function matches(string $method, string $path): bool
   {
      // Check for a literal match first to avoid unnecessary processing
      if (
         $this->method === $method
         && $this->path === $path
      ) {
         return true;
      }

      $parameterNames = [];

      $pattern = $this->normalisePath($this->path);
      $pattern = $this->replaceRouteParametersWithRegex($pattern, $parameterNames);

      // If there are no route parameters and it wasn't a literal match,
      // this route will never match the requested path
      if (
         !str_contains($pattern, '+')
         && !str_contains($pattern, '*')
      ) {
         return false;
      }

      preg_match_all("#{$pattern}#", $this->normalisePath($path), $matches);

      $parameterValues = [];
      if (count($matches[1]) > 0) {
         // If the route matches the request path, assemble the parameters
         foreach ($matches[1] as $value) {
            array_push($parameterValues, $value);
         }
         // Create an empty array to handle optional parameters that may not be provided
         $emptyValues = array_fill(
            0,
            count($parameterNames),
            null
         );
         // Use += to combine arrays, adding values from the right-hand side
         // only if the same key doesn't already exist
         $parameterValues += $emptyValues;
         $this->parameters = array_combine(
            $parameterNames,
            $parameterValues,
         );
         return true;
      }
      return false;
   }

   public function method(): string
   {
      return $this->method;
   }

   /**
    * Normalize the path to ensure it starts and ends with a '/'
    * and remove any duplicate '/' characters.
    *
    * Examples:
    * - '' becomes '/'
    * - 'home' becomes '/home/'
    * - 'product/{id}' becomes '/product/{id}/'
    *
    * @param string $path
    * @return string
    */
   private function normalisePath(string $path): string
   {
      $path = trim($path, '/');
      $path = "/{$path}/";
      // remove multiple '/' in a row
      $path = preg_replace('/[\/]{2,}/', '/', $path);
      return $path;
   }

   public function parameters(): array
   {
      return $this->parameters;
   }

   public function path(): string
   {
      return $this->path;
   }

   /**
    * Replace route parameters with regex patterns to match optional or required parameters
    *
    * Examples:
    * - '/home/' remains '/home/'
    * - '/product/{id}/' becomes '/product/([^/]+)/'
    * - '/blog/{slug?}/' becomes '/blog/([^/]*)(?:/?)'
    *
    * @param string $path
    * @return string
    */
   private function replaceRouteParametersWithRegex(string $pattern, array &$parameterNames): string
   {
      $pattern = preg_replace_callback(
         '#{([^}]+)}/#',
         function (array $found) use (&$parameterNames) {
            array_push(
               $parameterNames,
               rtrim($found[1], '?')
            );
            // If it's an optional parameter, make the following slash optional as well
            if (str_ends_with($found[1], '?')) {
               return '([^/]*)(?:/?)';
            }
            return '([^/]+)/';
         },
         $pattern,
      );
      return $pattern;
   }
}
