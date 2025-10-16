<?php

use PrinceJohn\Weave\TokenParser;

use function PrinceJohn\Weave\weave;

it('can parse a token', function () {
    $parser = new TokenParser('aloha:upper|kebab');

    expect($parser->getKey())->toBe('aloha');
    expect($parser->getFunctionDefinitionList())->toHaveCount(2);
    expect($parser->getFunctionDefinitionList()[0]->function)->toBe('upper');
    expect($parser->getFunctionDefinitionList()[1]->function)->toBe('kebab');
});

it('works', function () {
    $string = weave('{{ controller:append,Controller|studly }}', ['User']);

    expect($string)->toBe('UserController');
});
