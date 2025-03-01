<?php

namespace Core\View\Engine;

use Core\View\View;

class BasicEngine implements Engine
{
   public function render(View $view): string
   {
      $contents = file_get_contents($view->path);
      foreach ($view->data as $key => $value) {
         $contents = str_replace(
            '{' . $key . '}',
            $value,
            $contents
         );
      }
      return $contents;
   }
}
