<?php

namespace App\Http\Controllers\Users;

use Core\Routing\Router;

class ShowRegisterFormController
{
   public function __construct(protected Router $router)
   {}

   public function handle()
   {
      return view('users/register', [
         'router' => $this->router,
      ]);
   }
}
