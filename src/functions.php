<?php

namespace PrinceJohn\Weave;

function weave(string $subject, array $variables = []): string
{

    return (new Weaver($subject, $variables))->weave();
}
