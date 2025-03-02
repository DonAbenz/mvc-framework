<?php

use Core\View;

if (!function_exists('view')) {
   function view(string $template, array $data = []): View\View
   {
      static $manager;

      if (!$manager) {
         $manager = new View\Manager();
         $manager->addPath(__DIR__ . '/../resources/views');

         $manager->addEngine('basic.php', new View\Engine\BasicEngine());
         $manager->addEngine('advanced.php', new View\Engine\AdvancedEngine());
         $manager->addEngine('php', new View\Engine\PhpEngine());

         $manager->addMacro('escape', fn($value) => htmlspecialchars($value));
         $manager->addMacro('includes', fn(...$params) => print view(...$params));
      }

      return $manager->resolve($template, $data);
   }
}
