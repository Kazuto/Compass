<?php

use App\Support\Logging\Raid;

if (! function_exists('raid')) {
    function raid(string $description = null): Raid
    {
        return Raid::new($description);
    }
}
