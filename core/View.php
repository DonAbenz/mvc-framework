<?php
namespace Core;

class View
{
   public static function render($view, $data = [])
   {
      extract($data);
      ob_start();

      $viewFile = __DIR__ . "/../resources/views/{$view}.php";

      if (!file_exists($viewFile)) {
         die("View file not found: {$viewFile}");
      }

      require $viewFile;
      return ob_get_clean();
   }
}
