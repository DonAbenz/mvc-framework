<?php
require_once __DIR__ . "/../../core/View.php";

class HomeController
{
   public function index()
   {
      return View::render('home', ['message' => 'Welcome to My MVC Framework!']);
   }
}
