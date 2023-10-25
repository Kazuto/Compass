<?php

namespace App\Exceptions;

use Exception as BaseException;
use Throwable;

class Exception extends BaseException
{
    public static function forward(Throwable $e): self
    {
        return new self($e->getMessage());
    }
}
