<?php

namespace PrinceJohn\Weave\Exceptions;

use Exception;

final class MalformedTokenException extends Exception
{
    public const BLANK_TOKEN = 1000;

    public const BLANK_FUNCTION = 1001;

    public static function blankToken(): MalformedTokenException
    {
        return new MalformedTokenException('A token cannot be blank.', MalformedTokenException::BLANK_TOKEN);
    }

    public static function blankFunction(): MalformedTokenException
    {
        return new MalformedTokenException('A function name must be provided after the colon.', MalformedTokenException::BLANK_FUNCTION);
    }
}
