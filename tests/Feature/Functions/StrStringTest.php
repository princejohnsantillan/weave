<?php

use function PrinceJohn\Weave\weave;

it('generates an empty string when none is provided', function () {
    $of = weave('{{=str}}');
    expect($of)->toBe('');
});

it('generates a string from the parameter when none is provided', function () {
    $of = weave('{{=str:Hello}}');
    expect($of)->toBe('Hello');
});
