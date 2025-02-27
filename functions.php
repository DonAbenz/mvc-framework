<?php

function dump($value)
{
   echo "<pre>";
   var_dump($value);
   echo "</pre>";
}

function dd($value)
{
   dump($value);
   die();
}

function abort($code)
{
   global $routes;
   header('HTTP/1.1 500 Internal Server Error');
   $routes[$code]();
}

set_error_handler(function ($e) {
   http_response_code(500);
   echo "<pre>";
   echo "Server error: " . $e->getMessage();
   echo "</pre>";
});

set_exception_handler(function ($e) {
   http_response_code(500);
   echo "<pre>";
   echo "Server error: " . $e->getMessage();
   echo "</pre>";
});
