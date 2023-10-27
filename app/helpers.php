<?php

declare(strict_types=1);

use App\Support\Logging\Raid;

if (! function_exists('raid')) {
    function raid(string $description, Closure $closure): mixed
    {
        $raid = Raid::new()->start($description);

        $response = $closure($raid);

        $raid->end($description);

        return $response;
    }
}

if (! function_exists('keyFromToggle')) {
    /** Filters request toggles for true values and returns the keys */
    function keyFromToggle(array $toggles): array
    {
        return collect($toggles)
            ->filter(fn ($item) => (bool) $item)
            ->keys()
            ->toArray();
    }
}
