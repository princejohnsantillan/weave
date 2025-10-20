<?php

use function PrinceJohn\Weave\weave;

it('can get a string from the config using the key from the input', function () {
    $config = weave('{{regex=config}}', ['weave.token_regex']);

    expect($config)->toBe(config('weave.token_regex'));
});

it('can get a string from the config using the key from the parameter', function () {
    $config = weave('{{=config:weave.token_regex}}');

    expect($config)->toBe(config('weave.token_regex'));
});
