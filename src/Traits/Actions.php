<?php

namespace TinyPixel\Hooks\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;

/**
 * Actions
 */
trait Actions
{
    /**
     * Instantiate filters.
     *
     * @param  Collection
     * @return void
     */
    public function applyActions(): void
    {
        $this->getActions()->each(function ($filter) {
            if (method_exists($this, $method = Str::camel($filter->name))) {
                add_action($filter->name, [$this, $method], $this->getActionArgs($method));
            }
        });
    }

    /**
     * Get actions.
     *
     * @return Collection
     */
    public function getActions()
    {
        if (! $actions = wp_cache_get('actions', 'tinypixel-wp-hooks')) {
            $actions = Collection::make(
                json_decode(file_get_contents(
                    __DIR__ . "/../schema/actions.json"
                ))
            );

            wp_cache_add('actions', $actions, 'tinypixel-wp-hooks');
        }

        return $actions;
    }

    /**
     * Get any additional arguments
     *
     * @param  string
     * @return array|null
     */
    protected function getActionArgs(string $key)
    {
        return trait_exists('HookArguments', false) ? $this->getHookArguments($key) : null;
    }

    /**
     * Remove filters.
     *
     * @param  array
     * @return void
     */
    protected function removeActions(array $filters): void
    {
        foreach($filters as $k => $v) {
            remove_action($k, $v);
        }
    }
}
