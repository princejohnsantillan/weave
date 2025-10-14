<?php

use PrinceJohn\Weave\TokenParser;

use function PrinceJohn\Weave\weave;

it('returns a successful response', function () {
    $parser = new TokenParser('aloha:upper|kebab');

    expect($parser->getKey())->toBe('aloha');
    expect($parser->getFunctions())->toHaveCount(2);
    expect($parser->getFunctions()[0]->function)->toBe('upper');
    expect($parser->getFunctions()[1]->function)->toBe('kebab');
});

it('works', function () {
    $string = weave('Hello {{name}}!', ['world']);

    expect($string)->toBe('Hello world!');
});
