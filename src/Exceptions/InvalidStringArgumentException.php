<?php

namespace PrinceJohn\Weave\Exceptions;

use Exception;

final class InvalidStringArgumentException extends Exception
{
    public const ARRAY_CONVERSION = 1000;

    public static function arrayConversion(): InvalidStringArgumentException
    {
        return new InvalidStringArgumentException('Array cannot be converted to string.'.InvalidStringArgumentException::ARRAY_CONVERSION);
    }
}
