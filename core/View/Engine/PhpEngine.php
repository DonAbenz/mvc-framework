<?php

namespace Core\View\Engine;

use Core\View\View;

class PhpEngine implements Engine
{
   use HasManager;

   protected $layouts = [];

   public function __call(string $name, $values)
   {
      return $this->manager->useMacro($name, ...$values);
   }
   
   protected function extends(string $template): static
   {
      $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
      $this->layouts[realpath($backtrace[0]['file'])] = $template;
      return $this;
   }

   public function render(View $view): string
   {
      extract($view->data);

      ob_start();
      include($view->path);
      $contents = ob_get_clean();

      if ($layout = $this->layouts[$view->path] ?? null) {

         $contentsWithLayout = view($layout, array_merge(
            $view->data,
            ['contents' => $contents],
         ));

         return $contentsWithLayout;
      }

      return $contents;
   }
}
