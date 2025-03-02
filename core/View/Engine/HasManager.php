<?php

namespace Core\View\Engine;

use Core\View\Manager;

trait HasManager
{
   protected Manager $manager;
   
   public function setManager(Manager $manager): static
   {
      $this->manager = $manager;
      return $this;
   }
}
