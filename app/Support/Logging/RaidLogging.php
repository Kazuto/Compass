<?php

namespace App\Support\Logging;

trait RaidLogging
{
    protected Raid $raid;

    public function __construct()
    {
        $this->raid = raid();

        $this->raid->start($this->description ?? '');
    }

    public function __destruct()
    {
        $this->raid->end($this->description ?? '');
    }
}
