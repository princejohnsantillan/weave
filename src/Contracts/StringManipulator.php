<?php

namespace PrinceJohn\Weave\Contracts;

use PrinceJohn\Weave\FunctionBlueprint;

interface StringManipulator
{
    public static function handle(FunctionBlueprint $blueprint, string $string): string;
}
