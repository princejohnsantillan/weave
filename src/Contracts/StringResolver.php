<?php

namespace PrinceJohn\Weave\Contracts;

use PrinceJohn\Weave\TokenParser;

interface StringResolver
{
    public function handle(TokenParser $parser, ?string $string = null): ?string;
}
