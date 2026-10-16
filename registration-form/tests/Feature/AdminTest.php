<?php

use App\Models\Admin;
use App\Models\Member;
use Inertia\Testing\AssertableInertia as Assert;

test('admin try open admin panel be non authenticated', function () {
    $this->get('/admin/panel')->assertRedirect('/admin/login');
});

test('admin try open login page be non authenticated', function () {
    $this->get('/admin/login')
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('AdminAuth')
        );
});

test('admin try open login page be authenticated', function () {
    Admin::factory()->create();
    $this->post('/admin/login', ['username' => 'admin', 'password' => 'admin'])->assertRedirect('/admin/panel');

    $this->get('/admin/login')->assertRedirect('/admin/panel');
});

test('admin try open admin panel be authenticated', function () {
    Admin::factory()->create();
    $this->post('/admin/login', ['username' => 'admin', 'password' => 'admin'])->assertRedirect('/admin/panel');

    $this->get('/admin/panel')
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('AdminPanel')
            ->has('members')
        );
});

test('admin try login be authenticated', function () {
    Admin::factory()->create();
    $this->post('/admin/login', ['username' => 'admin', 'password' => 'admin'])->assertRedirect('/admin/panel');
    $this->post('/admin/login')->assertRedirect('/admin/panel');
});

test('admin try login with wrong credentials', function () {
    Admin::factory()->create();
    $this->from('/admin/login')
        ->post('/admin/login', ['username' => 'admin', 'password' => 'wrong password'])
        ->assertRedirect('/admin/login')
        ->assertSessionHasErrors('credentials');
});

test('admin try edit member', function () {
    $registeredMemberData = Member::factory()->make()->getAttributes();
    $this->post('/register/steps/one', $registeredMemberData);
    $member = Member::where('email', $registeredMemberData['email'])->first();

    $admin = Admin::factory()->create();

    $editedMemberDataByAdmin = [];
    $editedMemberDataByAdmin['company'] = 'Test Edit Company';
    $editedMemberDataByAdmin['report_subject'] = 'New Report Subject';

    $this->from('/admin/panel')->actingAs($admin)
        ->patch("/admin/members/$member->id", $editedMemberDataByAdmin)
        ->assertSessionHasNoErrors()
        ->assertRedirectBack();

    $this->assertDatabaseHas('members', [
        'id' => $member->id,
        'company' => 'Test Edit Company',
        'report_subject' => 'New Report Subject',
    ]);
});

test('admin try delete member', function () {
    $member = Member::factory()->create();
    $admin = Admin::factory()->create();

    $this->from('/admin/panel')->actingAs($admin)
        ->delete("/admin/members/$member->id")
        ->assertSessionHasNoErrors()
        ->assertRedirectBack();
    $this->assertDatabaseMissing('members', ['id' => $member->id]);
});

test('admin try switch visibility member', function () {
    $member = Member::factory()->create();
    $admin = Admin::factory()->create();

    $this->assertDatabaseHas('members', ['id' => $member->id, 'is_visible' => true]);

    $this->from('/admin/panel')->actingAs($admin)
        ->patch("/admin/members/$member->id/visibility", ['is_visible' => false])
        ->assertSessionHasNoErrors()
        ->assertRedirectBack();
    $this->assertDatabaseHas('members', ['id' => $member->id, 'is_visible' => false]);
});
