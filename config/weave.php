<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Token Regex
    |--------------------------------------------------------------------------
    |
    | This is the regex used to identify the tokens off of the strings.
    | PHP's preg_match_all will generate two sets of array, first is
    | for the placeholders and second is for the tokens itself.
    |
    */

    'token_regex' => env('WEAVE_TOKEN_REGEX', '/(?<!\\\\)\{\{\s*([^{}]*?)\s*\}\}(?<!\\\\)/'),

    /*
    |--------------------------------------------------------------------------
    | Custom String Manipulators
    |--------------------------------------------------------------------------
    |
    | This array of custom string manipulators will be checked first before
    | looking into the list of built-in manipulators, that means you can
    | override existing functionalities too. Or just provide your own.
    |
    */

    'string_manipulators' => [
        'now' => \PrinceJohn\Weave\Manipulators\NowString::class,
        'config' => \PrinceJohn\Weave\Manipulators\ConfigString::class,
    ],

];
