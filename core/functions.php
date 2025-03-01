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

set_error_handler(function ($e) {
   http_response_code(500);
   echo "<pre>";
   echo "Server error: ";
   echo "<br>";
   echo $e;
   echo "</pre>";
});

set_exception_handler(function ($e) {
   http_response_code(500);
   echo "<pre>";
   echo "Exception: ";
   echo "<br>";
   echo $e;
   echo "</pre>";
});
