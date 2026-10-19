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
        $admin = Admin::factory()->create();
        $member = Member::factory()->create();
        $testEditFirstName = 'Test Edit First Name';
        $testEditCompany = 'Test Edit Company';

        $browser->loginAs($admin->id)
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
        expect($member->company)->toBe($testEditCompany)
            ->and($member->first_name)->toBe($testEditFirstName);

    });
});

test('admin switch visibility member', function () {
    $this->browse(function (Browser $browser) {
        $admin = Admin::factory()->create();
        $member = Member::factory()->create();

        $browser->loginAs($admin->id)
            ->visit('/admin/panel')
            ->waitForLocation('/admin/panel')
            ->waitForTextIn("@v-s-m-$member->id", 'VISIBLE')
            ->screenshot('before switch visibility')
            ->click("@switch-visibility-member-$member->id")
            ->waitForTextIn("@v-s-m-$member->id", 'HIDDEN')
            ->screenshot('after switch visibility');
    });
});

test('admin delete member', function () {
    $this->browse(function (Browser $browser) {
        $admin = Admin::factory()->create();
        $member = Member::factory()->create();

        $browser->loginAs($admin->id)
            ->visit('/admin/panel')
            ->waitForLocation('/admin/panel')
            ->click("@delete-member-$member->id")
            ->waitFor("@confirm-delete-member-$member->id")
            ->screenshot('confirm delete member')
            ->click("@confirm-delete-member-$member->id")
            ->waitUntilMissing("@confirm-delete-member-$member->id")
            ->screenshot('after delete member');
        $this->assertDatabaseMissing('members', ['id' => $member->id]);
    });
});