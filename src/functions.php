<?php

namespace PrinceJohn\Weave;

function weave(string $subject, array $variables = []): string
{
    return (new Weaver($subject, $variables))->weave();
}

function is_none($variable): bool
{
    return $variable instanceof None;
}
