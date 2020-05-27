<?php

namespace TinyPixel\Hooks\Traits;

use Illuminate\Support\Collection;

/**
 * Hook arguments
 */
trait HookArguments
{
    /**
     * Get filter arguments merged from class properties
     * and whatever array values are returned from setArgs
     *
     * @return array
     */
    protected function getHookArguments(string $key): array
    {
        $this->args = Collection::make($this->args)->mergeRecursive($this->setArgs());

        return $this->args->has($key) ? $this->args->get($key) : [];
    }
}
