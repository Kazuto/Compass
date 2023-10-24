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
