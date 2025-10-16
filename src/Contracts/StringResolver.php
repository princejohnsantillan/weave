<?php

namespace PrinceJohn\Weave\Contracts;

use PrinceJohn\Weave\None;
use PrinceJohn\Weave\TokenParser;

interface StringResolver
{
    public function handle(TokenParser $parser, None|string $string): false|string;
}
