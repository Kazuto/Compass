<?php

declare(strict_types=1);

namespace Tests\Unit\Actions;

use App\Actions\Action;
use DeepCopy\Exception\PropertyException;

it('child class requires static properties', function () {
    app(ActionTest::class);
})->throws(PropertyException::class);

class ActionTest extends Action
{
    public function execute()
    {
    }
}
