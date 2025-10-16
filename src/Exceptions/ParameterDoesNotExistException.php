<?php

namespace PrinceJohn\Weave\Exceptions;

use Exception;

final class ParameterDoesNotExistException extends Exception
{
    public static function onIndex(int $index): ParameterDoesNotExistException
    {
        return new ParameterDoesNotExistException("[Index({$index}) parameter does not exist.");
    }
}
