<?php

use PrinceJohn\Weave\Exceptions\MalformedTokenException;
use PrinceJohn\Weave\FunctionDefinition;
use PrinceJohn\Weave\None;
use PrinceJohn\Weave\TokenParser;

it('does not parse an empty string', function () {
    new TokenParser('   ');
})->throws(exception: MalformedTokenException::class, exceptionCode: MalformedTokenException::BLANK_TOKEN);

it('uses a None object as the key if none is provided', function () {
    $parser = new TokenParser('=config');

    expect($parser->getKey())->toBeInstanceOf(None::class);
    expect($parser->hasKey())->toBeFalse();
});

it('can get the key from a token with a function', function () {
    $parser = new TokenParser('this-key=config');

    expect($parser->getKey())->toBe('this-key');
    expect($parser->hasKey())->toBeTrue();
});

it('can get the key from a token without a function', function () {
    $parser = new TokenParser('that-key');

    expect($parser->getKey())->toBe('that-key');
    expect($parser->hasKey())->toBeTrue();
});

it('can get a function definition list ', function () {
    $parser = new TokenParser('key=func1:param1,param2|func2:param1');

    expect($parser->hasFunctions())->toBeTrue();
    expect($parser->getFunctionDefinitionList())->toHaveCount(2);

    foreach ($parser->getFunctionDefinitionList() as $function) {
        expect($function)->toBeInstanceOf(FunctionDefinition::class);
    }

    expect($parser->getFunctionDefinitionList()[0]->function)->toBe('func1');
    expect($parser->getFunctionDefinitionList()[1]->function)->toBe('func2');
    expect($parser->getFunctionDefinitionList()[2] ?? null)->toBeNull();
    expect($parser->getFunctionDefinitionList()[0]->parameters)->toBe(['param1', 'param2']);
    expect($parser->getFunctionDefinitionList()[1]->parameters)->toBe(['param1']);
});

it('can escape reserved parser characters', function () {
    $parser = new TokenParser('new\=key=func\:1:This is a \,,That is a \||func\:2:0,1');

    expect($parser->hasKey())->toBeTrue();
    expect($parser->getKey())->toBe('new=key');
    expect($parser->hasFunctions())->toBeTrue();
    expect($parser->getFunctionDefinitionList())->toHaveCount(2);
    expect($parser->getFunctionDefinitionList()[0]->function)->toBe('func:1');
    expect($parser->getFunctionDefinitionList()[1]->function)->toBe('func:2');
    expect($parser->getFunctionDefinitionList()[0]->parameters)->toBe(['This is a ,', 'That is a |']);
    expect($parser->getFunctionDefinitionList()[1]->parameters)->toBe(['0', '1']);
});
