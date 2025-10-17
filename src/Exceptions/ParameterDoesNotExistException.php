<?php

namespace PrinceJohn\Weave\Exceptions;

use Exception;

final class ParameterDoesNotExistException extends Exception
{
    public const ON_INDEX = 1020;

    public static function onIndex(int $index): ParameterDoesNotExistException
    {
        return new ParameterDoesNotExistException("[Index({$index}) parameter does not exist.", ParameterDoesNotExistException::ON_INDEX);
    }
}
