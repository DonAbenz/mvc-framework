<?php
namespace App\Http\Controllers;

class ShowHomeController
{
   public function handle()
   {
      return view('home', ['name' => 'Don']);
   }
}
