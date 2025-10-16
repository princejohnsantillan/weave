<?php

namespace PrinceJohn\Weave\Manipulators;

use PrinceJohn\Weave\Contracts\StringManipulator;
use PrinceJohn\Weave\FunctionDefinition;

class NowString implements StringManipulator
{
    public static function handle(FunctionDefinition $definition, ?string $string): string
    {
        return $definition->hasParameters()
            ? now()->format($definition->firstParameterOrFail())
            : now();
    }
}
