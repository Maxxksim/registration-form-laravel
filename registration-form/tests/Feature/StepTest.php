<?php

declare(strict_types=1);

use App\Models\Admin;
use App\Models\Member;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\AssertableInertia as Assert;

test('user get step one', function () {

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

test('user post step one', function () {

    $generatedMemberData = Member::factory()->make()->getAttributes();
    $this->post('/register/steps/one', $generatedMemberData)
        ->assertRedirect('/register/steps/two');

    $this->assertDatabaseHas('members', ['email' => $generatedMemberData['email']]);

});

test('user get step two', function () {

    session(['currentStep' => 'two']);
    $this->get('/register/steps/two')
        ->assertOk()
        ->assertSessionHas(['currentStep' => 'two'])
        ->assertInertia(fn(Assert $page) => $page
            ->component('StepTwo')
        );
});

test('user post step two', function () {
    Storage::fake('public');
    $generatedMemberData = Member::factory()->make()->getAttributes();

    $this->post('/register/steps/one', $generatedMemberData);
    $member = Member::where('email', $generatedMemberData['email'])->first();

    $generatedMemberData = [
        'company' => fake()->company(),
        'position' => fake()->text(255),
        'about_me' => fake()->realText(500),
        'photo' => UploadedFile::fake()->image('photo.png', 500, 500)
    ];

    $this->post('/register/steps/two', $generatedMemberData)->assertRedirect('/register/steps/thanks');
    Storage::disk('public')->assertExists($member->path_to_photo);
});

test('user get step thanks', function () {
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

test('user start over', function () {
    $this->get('/register/start')->assertRedirect('/');
});

test('get index when user first time here or start over', function () {
    $this->get('/')->assertRedirect('/register/steps/one');
});

test('user try get step two when now step one', function () {
    session(['currentStep' => 'one']);
    $this->get('/register/steps/two')
        ->assertRedirect('/register/steps/one')
        ->assertSessionHasErrors('error', "You must pass step one at first.");
});

test('user try get another step when on step thanks', function () {
    session(['currentStep' => 'thanks']);
    $this->get('/register/steps/one')->assertRedirect('/register/steps/thanks');
});

test('user try post step one with invalid data', function () {

    $memberData = [
        'first_name' => 1,
        'last_name' => 2,
        'birthdate' => 'invalid birthdate',
        'report_subject' => null,
        'country' => 'no existing country',
        'phone' => 'invalid phone',
        'email' => '*&1233/\+)(invalidemail@test.mail'
    ];

    $this->post('/register/steps/one', $memberData)
        ->assertStatus(302)
        ->assertSessionHasErrors(array_keys($memberData));
});

test('user try update data on first step when first step already passed', function () {

    $generatedMember = Member::factory()->make();
    $this->post('/register/steps/one', $generatedMember->getAttributes())
        ->assertRedirect('/register/steps/two');

    $newGeneratedData = Member::factory()->make(['email' => $generatedMember->email])->getAttributes();
    $this->post('/register/steps/one', $newGeneratedData)->assertRedirect('/register/steps/two');
    $memberNewData = Member::where('email', $generatedMember->email)->first()->getAttributes();

    $newGeneratedData
        |> array_keys(...)
        |> (fn($x) => Arr::only($memberNewData, $x))
        |> (fn($x) => expect($newGeneratedData)->toBe($x));
    expect(Member::where('email', $generatedMember->email)->count())->toBe(1);

});

test('user register new record if email another while trying update data on first step', function () {
    $generatedMemberData = Member::factory()->make()->getAttributes();
    $this->post('/register/steps/one', $generatedMemberData)
        ->assertRedirect('/register/steps/two');

    $generatedMemberData['email'] = fake()->email();
    $this->post('/register/steps/one', $generatedMemberData)->assertRedirect('/register/steps/two');
    $memberNewData = Member::where('email', $generatedMemberData['email'])->first()->only(array_keys($generatedMemberData));


    expect(Arr::except($generatedMemberData, 'email'))->toBe(Arr::except($memberNewData, 'email'))
        ->and(Member::where('email', $generatedMemberData['email'])->count())->toBe(1)
        ->and(Member::where('email', $memberNewData['email'])->count())->toBe(1);

});

test('user try post step two with invalid data', function () {
    session(['currentStep' => 'two']);
    $memberData = [
        'company' => 3,
        'position' => fake()->realTextBetween(256, 300),
        'about_me' => fake()->realTextBetween(501, 600),
        'photo' => UploadedFile::fake()->create('photo', 3073, 'png')
    ];

    $this->post('/register/steps/two', $memberData)
        ->assertStatus(302)
        ->assertSessionHasErrors(array_keys($memberData));
});

test('user try pass step two when has been already deleted by admin', function () {
    $memberData = Member::factory()->make()->getAttributes();
    $this->post('/register/steps/one', $memberData)->assertRedirect('/register/steps/two');
    $member = Member::where('email', $memberData['email'])->first();

    $this->from('/admin/panel')
        ->actingAs(Admin::factory()->create())
        ->delete("/admin/members/$member->id")
        ->assertSessionHasNoErrors()
        ->assertRedirectBack();

    $response = $this->post('/register/steps/two')
        ->assertRedirect('/register/steps/one');

    $this->followRedirects($response)
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('StepOne')
            ->where('errors.error', 'We couldn\'t find your registration. Please pass the first step again.')
        );

});

