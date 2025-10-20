<?php

use PrinceJohn\Weave\Exceptions\RequiredStringException;

use function PrinceJohn\Weave\weave;

it('throws an exception when the string is required but is missing', function () {
    weave('{{=required}}');
})->throws(RequiredStringException::class);

it('throws an exception when the string is required but is missing from the input array', function () {
    weave('{{name=required}}', ['greetings' => 'hello']);
})->throws(RequiredStringException::class);
