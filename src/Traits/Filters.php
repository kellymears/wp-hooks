<?php

namespace TinyPixel\Hooks\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;

/**
 * Filters
 */
trait Filters
{
    /**
     * Instantiate filters.
     *
     * @param  Collection
     * @return void
     */
    public function applyFilters()
    {
        $this->getFilters()->each(function ($filter) {
            if (method_exists($this, $method = Str::camel($filter->name))) {
                add_filter($filter->name, [$this, $method], $this->getFilterArgs($method));
            }
        });
    }

    /**
     * Get filters.
     *
     * @return Collection
     */
    public function getFilters()
    {
        if (! $filters = wp_cache_get('filters', 'tinypixel-wp-hooks')) {
            $filters = Collection::make(
                json_decode(file_get_contents(
                    __DIR__ . "/../schema/filters.json"
                ))
            );

            wp_cache_add('filters', $filters, 'tinypixel-wp-hooks');
        }

        return $filters;
    }

    /**
     * Get any additional arguments
     *
     * @param  string
     * @return array|null
     */
    protected function getFilterArgs(string $key)
    {
        return trait_exists('HookArguments', false) ? $this->getHookArguments($key) : null;
    }

    /**
     * Remove filters.
     *
     * @param  array
     * @return void
     */
    protected function removeFilters(array $filters): void
    {
        foreach($filters as $k => $v) {
            remove_filter($k, $v);
        }
    }
}
