<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\Logging\RaidLogging;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use RaidLogging {
        RaidLogging::__construct as protected __raidConstruct;
        RaidLogging::__destruct as protected __raidDestruct;
    }
    use ValidatesRequests;
}
