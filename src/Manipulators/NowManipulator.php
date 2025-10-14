<?php

namespace PrinceJohn\Weave\Manipulators;

use PrinceJohn\Weave\Contracts\StringManipulator;
use PrinceJohn\Weave\FunctionBlueprint;

class NowManipulator implements StringManipulator
{
    public static function handle(FunctionBlueprint $blueprint, string $string): string
    {
        return now()->format(...$blueprint->parameters);
    }
}
