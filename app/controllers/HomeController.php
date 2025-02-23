<?php
namespace App\Controllers;

use App\Models\User;
use Core\View;

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
