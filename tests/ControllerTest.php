<?php

use PHPUnit\Framework\TestCase;

require_once "./app/controllers/HomeController.php";

class ControllerTest extends TestCase
{
   public function testIndexReturnsMessage()
   {
      $controller = new HomeController();
      $this->assertEquals("200 OK", $controller->index());
   }
}
