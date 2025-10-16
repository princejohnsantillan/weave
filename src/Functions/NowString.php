<?php

namespace PrinceJohn\Weave\Functions;

use PrinceJohn\Weave\Contracts\StringFunction;
use PrinceJohn\Weave\FunctionDefinition;
use PrinceJohn\Weave\None;

class NowString implements StringFunction
{
    public static function handle(FunctionDefinition $definition, None|string $string): string
    {
        return $definition->hasParameters()
            ? now()->format($definition->firstParameterOrFail())
            : now();
    }
}
