<?php

namespace App\Exceptions;

class CommandException extends Exception
{
    public static function unsuccessful(): self
    {
        return new self('The command did not execute successfully.');
    }
}
