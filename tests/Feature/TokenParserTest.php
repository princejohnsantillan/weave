<?php

use PrinceJohn\Weave\Exceptions\MalformedTokenException;
use PrinceJohn\Weave\TokenParser;

it('does not parse an empty string', function () {
    new TokenParser('   ');
})->throws(exception: MalformedTokenException::class, exceptionCode: MalformedTokenException::BLANK_TOKEN);

it('does not parse tokens with empty function definition when a colon exists', function () {
    new TokenParser('key:');
})->throws(exception: MalformedTokenException::class, exceptionCode: MalformedTokenException::BLANK_FUNCTION);
