<?php

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

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

set_error_handler(function ($e) {
   if (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'dev') {
      $whoops = new Run();
      $whoops->pushHandler(new PrettyPageHandler());
      $whoops->register();
      throw $e;
   }
});

set_exception_handler(function ($e) {
   if (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'dev') {
      $whoops = new Run();
      $whoops->pushHandler(new PrettyPageHandler());
      $whoops->register();
      throw $e;
   }
});
