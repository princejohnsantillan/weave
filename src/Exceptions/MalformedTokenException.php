<?php

namespace PrinceJohn\Weave\Exceptions;

use Exception;

final class MalformedTokenException extends Exception
{
    public static function multipleColonDetected(): MalformedTokenException
    {
        return new MalformedTokenException('A token cannot have more than one colon.');
    }
}
