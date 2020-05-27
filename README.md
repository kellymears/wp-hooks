# WP Hooks

Traits and other OOP helpers for dealing with WordPress' actions and filters APIs.

Experimental, work-in-progress.

## What now?

Make a class that extends `\TinyPixel\Hooks\Hooks`.

Methods in this class are bound to WordPress actions and filters.

So, if you want to write an `init` action into your new Hookable class, you would write:

```php
<?php

public function init()
{
    // init stuff
}
```

And if you want to write an `admin_init` action, you would write:

```php
<?php

public function adminInit()
{
    // admin_init stuff
}
```

Notice that the casing is camel, not snake, for these method names. The dude does not abide.

## Instantiating

When you extend `\TinyPixel\Hooks\Hooks` these filters and hooks will be called for you.

If you implement the `\TinyPixel\Hooks\Traits` directly you'll need to do that yourself:

```php
<?php

namespace Plugin;

use TinyPixel\Hooks\Traits\Actions;
use TinyPixel\Hooks\Traits\Filters;
use TinyPixel\Hooks\Traits\HookArguments;
use TinyPixel\Hooks\Contracts\Actionable;
use TinyPixel\Hooks\Contracts\Filterable;

class PluginHooks implements Actionable, Filterable
{
    use Actions;
    use Filters;

    public function __invoke()
    {
        $this->applyFilters();
        $this->applyActions();
    }
}
```

I like doing this on `__invoke` because then you just pass the `Plugin\PluginHooks::class` around to different event systems (which may be expecting a function) and not be bothered futzing with namespacing or closures.

## Caching

The actions and filters are sourced from a JSON file. Filesystem ops in PHP are expensive so the results of this are cached under the `tinypixel-wp-hooks` key.

I'm going to be real with you here, I have limited knowledge of if this is effective.

I can say that I measured doing some simple calls this way vs. the traditional way and this is slower. But not by a lot. Not even consistently slower.

But, on average, slower.
