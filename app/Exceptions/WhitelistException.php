<?php

namespace App\Exceptions;

class WhitelistException extends Exception
{
    public static function notFound(): self
    {
        return new self("The E-Mail assigned to your account is not whitelisted. \n\n Please talk to an administrator for access.");
    }
}
