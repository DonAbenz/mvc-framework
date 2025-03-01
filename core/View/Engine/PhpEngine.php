<?php

namespace Core\View\Engine;

use Core\View\View;
use function view;

class PhpEngine implements Engine
{
   protected $layouts = [];

   protected function escape(string $content): string
   {
      return htmlspecialchars($content, ENT_QUOTES);
   }

   protected function extends(string $template): static
   {
      $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
      $this->layouts[realpath($backtrace[0]['file'])] = $template;
      return $this;
   }

   protected function includes(string $template, $data = []): void
   {
      print view($template, $data);
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
