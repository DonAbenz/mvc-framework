<?php

namespace App\Http\Controllers\Users;

use Core\Routing\Router;

class RegisterUserController
{
   public function __construct(protected Router $router) {}

   public function handle()
   {
      secure();
      
      $data = validate($_POST, [
         'name' => ['required'],
         'email' => ['required', 'email'],
         'password' => ['required', 'min:10'],
      ]);
      // use $data to create a database record...
      $_SESSION['registered'] = true;
      
      return redirect($this->router->route('show-home-page'));
   }
}
