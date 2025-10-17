<?php

namespace Tests\Feature;

use function PrinceJohn\Weave\weave;

it('can use a default string if token is unmatched', function () {
    $string = weave('{{:default,Hmmmm}}');

    expect($string)->toBe('Hmmmm');
});

it('can use a remove the token if token is unmatched', function () {
    $string = weave('{{name:default}}', ['greeting' => 'Hey!']);

    expect($string)->toBe('');
});
