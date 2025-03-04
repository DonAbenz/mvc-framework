<?php

use Core\View;
use Core\Validation;

if (!function_exists('csrf')) {
   function csrf()
   {
      $_SESSION['token'] = bin2hex(random_bytes(32));
      return $_SESSION['token'];
   }
}

if (!function_exists('redirect')) {
   function redirect(string $url)
   {
      header("Location: {$url}");
      exit;
   }
}

if (!function_exists('secure')) {
   function secure()
   {
      if (
         !isset($_POST['csrf']) || !isset($_SESSION['token']) ||
         !hash_equals($_SESSION['token'], $_POST['csrf'])
      ) {
         throw new Exception('CSRF token mismatch');
      }
   }
}

if (!function_exists('validate')) {
   function validate(array $data, array $rules)
   {
      static $manager;
      if (!$manager) {
         $manager = new Validation\Manager();
         // let's add the rules that come with the framework
         $manager->addRule('required', new Validation\Rule\RequiredRule());
         $manager->addRule('email', new Validation\Rule\EmailRule());
         $manager->addRule('min', new Validation\Rule\MinRule());
      }
      return $manager->validate($data, $rules);
   }
}

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
