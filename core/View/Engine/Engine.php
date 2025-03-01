<?php

namespace Core\View\Engine;

use Core\View\View;

interface Engine
{
   public function render(View $view): string;
}
