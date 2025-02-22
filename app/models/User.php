<?php

require_once __DIR__ . "/../../core/Model.php";

class User extends Model
{
   public function getUsers()
   {
      $stmt = $this->db->query("SELECT * FROM users");
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }
}
