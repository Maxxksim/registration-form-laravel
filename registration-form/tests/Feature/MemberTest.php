<?php

declare(strict_types=1);

use Inertia\Testing\AssertableInertia as Assert;

test('user try open member list', function () {
    $this->get('/members')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Members')
            ->has('members')
        );
});
