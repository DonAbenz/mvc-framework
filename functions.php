<?php

function dd($value)
{
   echo "<pre>";
   var_dump($value, $_SERVER, $_REQUEST);
   echo "</pre>";

   die();
}