<?php

use Illuminate\Support\Carbon;

use function PrinceJohn\Weave\weave;

it('can generate a string of the datetime now', function () {
    Carbon::setTestNow('2025-10-16 11:37:17');

    $now = weave('{{:now}}');
    expect($now)->toBe('2025-10-16 11:37:17');
});

it('can generate a formatted string of the datetime now', function () {
    Carbon::setTestNow('2025-10-16 11:37:17');

    $now = weave('{{:now,Y-m-d}}');
    expect($now)->toBe('2025-10-16');

    $now = weave('{{:now,H:i:s}}');
    expect($now)->toBe('11:37:17');
});
