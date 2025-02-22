<?php

class HomeController
{
   public function index()
   {
      require __DIR__ . "/../../app/views/home.php";

      return "200 OK";
   }
}
