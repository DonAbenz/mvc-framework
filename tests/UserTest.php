<?php

use PHPUnit\Framework\TestCase;

require_once "./app/models/User.php";

class UserTest extends TestCase
{
   public function test_get_users_returns_array()
   {
      $userModel = new User();
      $this->assertIsArray($userModel->getUsers());
   }

   public function test_get_users_returns_database_results()
   {
      $userModel = new User();
      $users = $userModel->getUsers();

      $this->assertNotEmpty($users);
      $this->assertArrayHasKey('name', $users[0]);
      $this->assertArrayHasKey('email', $users[0]);
   }
}
