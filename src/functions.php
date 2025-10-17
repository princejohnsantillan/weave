<?php

namespace PrinceJohn\Weave;

/**
 * @param  string[]|array<string,string>  $variables
 */
function weave(string $subject, array $variables = []): string
{
    return (new Weaver($subject, $variables))->weave();
}

function is_none(mixed $variable): bool
{
    return $variable instanceof None;
}
