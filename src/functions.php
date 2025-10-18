<?php

namespace PrinceJohn\Weave;

/**
 * @param  string|array<int|string,string>  $variables
 */
function weave(string $subject, string|array ...$variables): string
{
    return (new Weaver($subject, $variables))->weave();
}

function is_none(mixed $variable): bool
{
    return $variable instanceof None;
}

/**
 * @param  string|mixed[]  ...$args
 * @return array<string|int, string>
 */
function str_args(mixed ...$args): array
{
    $args = $args[0] ?? [];

    array_walk(
        $args,
        fn (&$arg) => ($arg = is_array($arg) ? $arg : [$arg])
    );

    return array_merge(...$args);
}
