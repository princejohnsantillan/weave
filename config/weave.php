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
    | Custom String Functions
    |--------------------------------------------------------------------------
    |
    | This array of custom string functions will be checked first before
    | looking into the list of built-in functions, that means you can
    | override existing behaviours too. Or just register your own.
    |
    */

    'string_functions' => [
        'config' => \PrinceJohn\Weave\Functions\ConfigString::class,
        'default' => \PrinceJohn\Weave\Functions\DefaultString::class,
        'now' => \PrinceJohn\Weave\Functions\NowString::class,
        'of' => \PrinceJohn\Weave\Functions\OfString::class,
        'required' => \PrinceJohn\Weave\Functions\RequiredString::class,
    ],

];
