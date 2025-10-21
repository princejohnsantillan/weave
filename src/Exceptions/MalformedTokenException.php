<?php

namespace PrinceJohn\Weave\Exceptions;

use Exception;

final class MalformedTokenException extends Exception
{
    public const BLANK_TOKEN = 1000;

    public static function blankToken(): MalformedTokenException
    {
        return new MalformedTokenException('A token cannot be blank.', MalformedTokenException::BLANK_TOKEN);
    }
}
