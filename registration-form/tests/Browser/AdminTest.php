<?php

declare(strict_types=1);

use App\Models\Admin;
use App\Models\Member;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;

pest()->use(DatabaseTruncation::class);

test('admin open panel', function () {

    $this->browse(function (Browser $browser) {
        Admin::factory()->create();
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
        Admin::factory()->create();
        $member = Member::factory()->create();
        $testEditFirstName = 'Test Edit First Name';
        $testEditCompany = 'Test Edit Company';

        $browser->loginAs(1)
            ->visit('/admin/panel')
            ->waitForLocation('/admin/panel')
            ->assertSee('Admin panel')
            ->screenshot('AdminPanel')
            ->waitFor("@edit-member-$member->id")
            ->click("@edit-member-$member->id")
            ->waitFor('form#form-edit-member')
            ->screenshot('form-edit-member')
            ->clear('first_name')
            ->type('first_name', $testEditFirstName)
            ->type('company', $testEditCompany)
            ->assertInputValue('first_name', $testEditFirstName)
            ->assertInputValue('company', $testEditCompany)
            ->doubleClick("@update-member-$member->id")
            ->waitForText($testEditFirstName)
            ->screenshot('editedMember');
        $member->refresh();
        dump($member->toArray());
        expect($member->company)->toBe($testEditCompany)
            ->and($member->first_name)->toBe($testEditFirstName);

    });
});