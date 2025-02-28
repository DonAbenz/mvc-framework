<?php

use Core\View\View;
use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase
{
   public function test_can_parse_basic_variable_string_template()
   {
      $engine = new Core\View\Engine\BasicEngine();
      $viewPath = __DIR__ . '/../resources/views/home.basic.php';

      $data = ['name' => 'Don'];
      $output = $engine->render(new View($engine, $viewPath, $data));

      $expectedContent = "Welcome Don!";
      $this->assertStringContainsString($expectedContent, $output);
   }

   public function test_can_compose_php_in_html_templates()
   {
      $engine = new Core\View\Engine\PhpEngine();
      $viewPath = __DIR__ . '/../resources/views/products/view.php';

      $data = ['product' => '123'];
      $output = $engine->render(new View($engine, $viewPath, $data));

      $this->assertStringContainsString("This is the product page for 123", $output);
   }
   
   public function test_can_compose_php_in_html_templates_avoiding_xss_hazard()
   {
      $engine = new Core\View\Engine\PhpEngine();
      $viewPath = __DIR__ . '/../resources/views/products/view.php';

      $data = [
         'product' => '123',
         'scary' => '<script>alert("boo!")</script>',
      ];
      $output = $engine->render(new View($engine, $viewPath, $data));

      $this->assertStringContainsString("&lt;script&gt;alert(&quot;boo!&quot;)&lt;/script&gt;", $output);
   }
}
