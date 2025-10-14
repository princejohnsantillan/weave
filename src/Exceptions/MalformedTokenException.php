<?php

namespace PrinceJohn\Weave\Exceptions;

use Exception;

final class MalformedTokenException extends Exception
{
    public static function multipleColonDetected(): MalformedTokenException
    {
        return new MalformedTokenException("A token can only have up to one colon.");
    }
}