<?php

return [
    'token_regex' => '/(?<!\\\\)\{\{\s*([^{}]*?)\s*\}\}(?<!\\\\)/',

    'string_manipulators' => [
        'now' => \PrinceJohn\Weave\Manipulators\NowString::class,
        'config' => \PrinceJohn\Weave\Manipulators\ConfigString::class,
    ],
];
