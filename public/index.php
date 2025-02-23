<?php
const BASE_PATH = __DIR__ . '/../';

spl_autoload_register(function ($class) {
   $prefixes = [
      'App\\' => realpath(__DIR__ . '/../app/') . '/', // Base directory for App namespace
      'Core\\' => realpath(__DIR__ . '/../core/') . '/' // Base directory for Core namespace
   ];

   foreach ($prefixes as $prefix => $baseDir) {
      if (strpos($class, $prefix) === 0) {
         $relativeClass = str_replace($prefix, '', $class);
         $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
         if (file_exists($file)) {
            require $file;
            return;
         } else {
            die("Class file not found: " . $file);
         }
      }
   }
});

require BASE_PATH . 'functions.php';
require BASE_PATH . 'config/config.php';
require BASE_PATH . 'router.php';
