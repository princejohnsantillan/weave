<?php

namespace PrinceJohn\Weave\Contracts;

use PrinceJohn\Weave\FunctionDefinition;
use PrinceJohn\Weave\None;

interface StringFunction
{
    public static function handle(FunctionDefinition $definition, None|string $string): string;
}
