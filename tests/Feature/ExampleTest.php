<?php

use PrinceJohn\Weave\TokenParser;

it('returns a successful response', function () {
    $parser = new TokenParser("{{aloha:upper|kebab}}");

    expect($parser->getKey())->toBe('aloha');
    expect($parser->getFunctions())->toBe([
        ['upper',[]],
        ['kebab',[]]
    ]);
});
