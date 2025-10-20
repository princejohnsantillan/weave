<?php

namespace PrinceJohn\Weave\Exceptions;

use Exception;

final class MalformedTokenException extends Exception
{
    public const BLANK_TOKEN = 2000;

    public const BLANK_FUNCTION = 2010;

    public static function blankToken(): MalformedTokenException
    {
        return new MalformedTokenException('A token cannot be blank.', MalformedTokenException::BLANK_TOKEN);
    }

    public static function blankFunction(): MalformedTokenException
    {
        return new MalformedTokenException('A function name must be provided after the equal sign.', MalformedTokenException::BLANK_FUNCTION);
    }
}
