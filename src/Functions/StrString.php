<?php

namespace PrinceJohn\Weave\Functions;

use PrinceJohn\Weave\Contracts\StringFunction;
use PrinceJohn\Weave\FunctionDefinition;
use PrinceJohn\Weave\None;

class StrString implements StringFunction
{
    public static function handle(FunctionDefinition $definition, string|None $string): string
    {
        return $definition->firstParameter() ?? '';
    }
}
