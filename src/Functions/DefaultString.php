<?php

namespace PrinceJohn\Weave\Functions;

use PrinceJohn\Weave\Contracts\StringFunction;
use PrinceJohn\Weave\FunctionDefinition;
use PrinceJohn\Weave\None;

use function PrinceJohn\Weave\is_none;

class DefaultString implements StringFunction
{
    public static function handle(FunctionDefinition $definition, string|None $string): string
    {
        if (is_none($string)) {
            return $definition->firstParameter() ?? '';
        }

        return $string;
    }
}
