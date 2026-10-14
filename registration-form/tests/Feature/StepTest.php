<?php

declare(strict_types=1);

use App\Models\Member;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\AssertableInertia as Assert;

test('get step one', function () {

    $this->get('/register/steps/one')
        ->assertOk()
        ->assertSessionHas(['currentStep' => 'one'])
        ->assertInertia(fn(Assert $page) => $page
            ->component('StepOne')
            ->has('countries')
            ->where('initialCountry', 'US')
            ->has('memberData')
        );
});

test('post step one', function () {

    $generatedMemberData = Member::factory()->make()->getAttributes();
    $this->post('/register/steps/one', $generatedMemberData)
        ->assertRedirect('/register/steps/two');

    $this->assertDatabaseHas('members', ['email' => $generatedMemberData['email']]);

});

test('get step two', function () {

    session(['currentStep' => 'two']);
    $this->get('/register/steps/two')
        ->assertOk()
        ->assertSessionHas(['currentStep' => 'two'])
        ->assertInertia(fn(Assert $page) => $page
            ->component('StepTwo')
        );
});

test('post step two', function () {

    $generatedMemberData = Member::factory()->make()->getAttributes();

    $this->post('/register/steps/one', $generatedMemberData);

    $generatedMemberData = [
        'company' => fake()->company(),
        'position' => fake()->text(255),
        'about_me' => fake()->realText(500),
        'photo' => UploadedFile::fake()->image('photo.png', 500, 500)
    ];

    $this->post('/register/steps/two', $generatedMemberData)->assertRedirect('/register/steps/thanks');

});

test('get step thanks', function () {
    session(['currentStep' => 'thanks']);
    $this->get('/register/steps/thanks')
        ->assertOk()
        ->assertSessionHas(['currentStep' => 'thanks'])
        ->assertInertia(fn(Assert $page) => $page
            ->component('StepThanks')
            ->has('countMembers')
            ->has('sharingData', 2)
        );
});



