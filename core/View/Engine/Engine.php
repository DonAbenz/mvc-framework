<?php

namespace Core\View\Engine;

use Core\View\Manager;
use Core\View\View;

interface Engine
{
   public function render(View $view): string;
   public function setManager(Manager $manager): static;
}
