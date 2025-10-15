<?php

namespace PrinceJohn\Weave\Manipulators;

use PrinceJohn\Weave\Contracts\StringManipulator;
use PrinceJohn\Weave\FunctionBlueprint;

class NowString implements StringManipulator
{
    public static function handle(FunctionBlueprint $blueprint, ?string $string): string
    {
        return $blueprint->hasParameters()
            ? now()->format($blueprint->firstParameter())
            : now();
    }
}
