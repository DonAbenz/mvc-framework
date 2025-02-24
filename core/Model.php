<?php

namespace Core;

use PDO;
use PDOException;

require __DIR__ . '/../config/database.php';

class Model
{
   protected $db;

   public function __construct()
   {
      try {
         $this->db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
         $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
         die("Database connection failed: " . $e->getMessage());
      }
   }
}
