<?php

return [
    'token_regex' => '/(?<!\\\\)\{\{\s*([^{}]*?)\s*\}\}(?<!\\\\)/',

    'string_manipulators' => [
        'now' => \PrinceJohn\Weave\Manipulators\NowManipulator::class,
    ],
];
