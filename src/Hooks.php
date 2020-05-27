<?php

namespace TinyPixel\Hooks;

use TinyPixel\Hooks\Traits\Actions;
use TinyPixel\Hooks\Traits\Filters;
use TinyPixel\Hooks\Traits\HookArguments;
use TinyPixel\Hooks\Contracts\Actionable;
use TinyPixel\Hooks\Contracts\Filterable;

/**
 * Hooks base class.
 */
abstract class Hooks implements Actionable, Filterable
{
    use Actions;
    use Filters;
    use HookArguments;

    public function __construct()
    {
        $this->applyFilters();
        $this->applyActions();
    }
}
