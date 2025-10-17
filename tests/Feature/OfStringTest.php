<?php

use function PrinceJohn\Weave\weave;

it('generates an empty string when none is provided', function () {
    $of = weave('{{:of}}');
    expect($of)->toBe('');
});

it('generates a string from the parameter when none is provided', function () {
    $of = weave('{{:of,Hello}}');
    expect($of)->toBe('Hello');
});

it('passes thru the given string', function () {
    $of = weave('{{:of,Hello}}', ['Hello']);
    expect($of)->toBe('Hello');

    $of = weave('{{:of}}', ['World']);
    expect($of)->toBe('World');
});
