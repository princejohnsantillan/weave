<?php

namespace PrinceJohn\Weave;

use PrinceJohn\Weave\Exceptions\InvalidStringArgumentException;

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

    $args = array_merge(...$args);

    array_walk($args, function (&$arg): void {
        if (is_array($arg)) {
            throw InvalidStringArgumentException::arrayConversion();
        }

        $arg = (string) $arg;
    });

    return $args;
}
