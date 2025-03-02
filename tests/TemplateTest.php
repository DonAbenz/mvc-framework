<?php

use Core\View\View;
use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase
{
   public function test_can_parse_basic_variable_string_template()
   {
      $output = view('home', ['name' => 'Don']);

      $expectedContent = "Welcome Don!";
      $this->assertStringContainsString($expectedContent, $output);
   }

   public function test_can_render_php_engine_templates()
   {
      $output = view('products/view', ['product' => '123']);

      $this->assertStringContainsString("This is the product page for 123", $output);
   }

   public function test_can_compose_php_in_html_templates_avoiding_xss_hazzard()
   {
      $output = view('products/view', [
         'product' => '123',
         'scary' => '<script>alert("boo!")</script>',
      ]);

      $this->assertStringContainsString("&lt;script&gt;alert(&quot;boo!&quot;)&lt;/script&gt;", $output);
   }

   public function test_can_render_advance_engine_templates()
   {
      $output = view('products/list', ['next' => 'https://google.com']);

      $this->assertStringContainsString("<a href=\"https://google.com\" target=\"_blank\">next 1</a>", $output);
   }
}
