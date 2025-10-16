<?php

namespace PrinceJohn\Weave\Functions;

use Illuminate\Support\Facades\Config;
use PrinceJohn\Weave\Contracts\StringFunction;
use PrinceJohn\Weave\FunctionDefinition;
use PrinceJohn\Weave\None;

use function PrinceJohn\Weave\is_none;

class ConfigString implements StringFunction
{
    public static function handle(FunctionDefinition $definition, None|string $string): string
    {
        return Config::string(
            $definition->firstParameterOrFail(is_none($string) ? null : $string),
            $definition->getParameterOrFail(1, '')
        );
    }
}
