<?php

use App\Controllers\HomeController;
use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase
{
   protected $router;

   protected function setUp(): void
   {
      $this->router = new \Core\Routing\Router();
   }

   private function sendRequest($method = 'GET', $path = '/')
   {
      $_SERVER['REQUEST_URI'] = $path;
      $_SERVER['REQUEST_METHOD'] = $method;
   }

   public function test_can_parse_basic_variable_string_template()
   {
      $engine = new Core\View\Engine\BasicEngine();
      $viewPath = __DIR__ . '/../resources/views/home.basic.php';

      $data = [
         'name' => 'Don',
      ];
      $output = $engine->render($viewPath, $data);

      $expectedContent = "Welcome Don!";
      $this->assertStringContainsString($expectedContent, $output);
   }
}
