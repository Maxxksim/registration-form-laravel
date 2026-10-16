<?php

declare(strict_types=1);

use App\Models\Member;
use Laravel\Dusk\Browser;

test('admin open panel', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/admin/panel')
            ->waitForLocation('/admin/login')
            ->assertVisible('form#form-admin-login')
            ->assertMissing('input:not([name=phone])[placeholder]')
            ->screenshot('adminLogin')
            ->type('username', 'admin')
            ->type('password', 'admin')
            ->doubleClick('button#admin-login-btn')
            ->waitForLocation('/admin/panel')
            ->assertSee('Admin panel');
    });
});

test('admin edit member', function () {
    $this->browse(function (Browser $browser) {

        $member = Member::factory()->create();

        $browser->loginAs(1)
            ->visit('/admin/panel')
            ->waitForLocation('/admin/panel')
            ->assertSee('Admin panel')
            ->screenshot('AdminPanel')
            ->click("@edit-member-$member->id")
            ->waitFor('form#form-edit-member')
            ->screenshot('form-edit-member');

    });
});