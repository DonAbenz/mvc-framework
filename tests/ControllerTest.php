<?php

use App\Controllers\HomeController;
use PHPUnit\Framework\TestCase;

class ControllerTest extends TestCase
{
   public function test_index_returns_message()
   {
      $controller = new HomeController();
      $response = $controller->index();

      // Expected content from the view
      $expectedContent = "<h1>Welcome to My MVC Framework!</h1>";

      // Check if the response contains the expected HTML output
      $this->assertStringContainsString($expectedContent, $response);
   }
}
