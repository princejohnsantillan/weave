<?php

namespace PrinceJohn\Weave\Exceptions;

use Exception;

final class MalformedTokenException extends Exception
{
    public static function blankToken(): MalformedTokenException
    {
        return new MalformedTokenException('A token cannot be blank.');
    }

    public static function multipleColon(): MalformedTokenException
    {
        return new MalformedTokenException('A token cannot have more than one colon.');
    }

    public static function blankFunction(): MalformedTokenException
    {
        return new MalformedTokenException('A function name must be provided after the colon.');
    }
}
