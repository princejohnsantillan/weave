<?php

namespace PrinceJohn\Weave\Manipulators;

use PrinceJohn\Weave\Contracts\StringManipulator;
use PrinceJohn\Weave\FunctionBlueprint;

class ConfigString implements StringManipulator
{
    public static function handle(FunctionBlueprint $blueprint, ?string $string): string
    {
        $key = $string ?? $blueprint->parameters[0] ?? null;

        if ($key === null) {
            return '';
        }

        return config($key) ?? '';
    }
}
