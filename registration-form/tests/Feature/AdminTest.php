<?php

use App\Models\Admin;
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