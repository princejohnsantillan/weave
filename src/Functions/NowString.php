<?php

namespace PrinceJohn\Weave\Functions;

use PrinceJohn\Weave\Contracts\StringFunction;
use PrinceJohn\Weave\FunctionDefinition;

class NowString implements StringFunction
{
    public static function handle(FunctionDefinition $definition, ?string $string): string
    {
        return $definition->hasParameters()
            ? now()->format($definition->firstParameterOrFail())
            : now();
    }
}
