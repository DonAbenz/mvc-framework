<?php
require_once __DIR__ . "/../../core/View.php";
require_once __DIR__ . "/../../app/models/User.php";

class HomeController
{
   public function index()
   {
      $userModel = new User();
      $users = $userModel->getUsers();

      return View::render('home', [
         'message' => 'Welcome to My MVC Framework!',
         'users' => $users
      ]);
   }
}
