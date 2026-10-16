<?php

use Laravel\Dusk\Browser;

test('passing steps fully', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
            ->assertPathIs('/register/steps/one')
            ->assertVisible('div#map')
            ->assertSee('To participate in the conference, please fill out the form:')
            ->assertVisible('form#form-step1')
            ->assertAttribute('input[name=phone]', 'placeholder', 'Enter your number')
            ->assertMissing('input:not([name=phone])[placeholder]');

        $browser->type('first_name', fake()->firstName())
            ->type('last_name', fake()->lastName())
            ->click('input[name=birthdate]')
            ->click('.flatpickr-calendar.open .today')
            ->waitUntilMissing('.flatpickr-calendar.open')
            ->assertInputValue('birthdate', today()->format('Y-m-d'))
            ->type('report_subject', fake()->realText(255))
            ->select('country', 'Ukraine')
            ->assertSelected('country', 'Ukraine')
            ->click('.iti__selected-country')
            ->waitFor('.iti__country-selector')
            ->click('.iti__country[data-iso2=ua]')
            ->waitUntilMissing('.iti__dropdown-content')
            ->type('phone', '677067131')
            ->type('email', fake()->email())
            ->screenshot('stepOne');

        $browser->doubleClick('button#step-one-btn')
            ->waitForLocation('/register/steps/two')
            ->assertPathIs('/register/steps/two');

        $browser->assertVisible('div#map')
            ->assertVisible('form#form-step2')
            ->assertMissing('input[placeholder]');

        $browser->type('company', fake()->realText(255))
            ->type('position', fake()->realText(255))
            ->type('about_me', fake()->realText(500))
            ->attach('photo', base_path('tests/TestFiles/testphoto.webp'));
        $this->assertStringEndsWith('testphoto.webp', $browser->value('input[name=photo]'));
        $browser->click('button#cancel-selected-photo-btn');
        $this->assertSame('', $browser->value('input[name=photo]'));
        $browser->attach('photo', base_path('tests/TestFiles/testphoto.webp'))
            ->screenshot('stepTwo');

        $browser->doubleClick('button#step-two-btn')
            ->waitForLocation('/register/steps/thanks')
            ->assertPathIs('/register/steps/thanks')
            ->assertVisible('div#map')
            ->assertVisible('a[href="/members"]')
            ->assertVisible('a[href="/register/start"]')
            ->assertVisible('a#sharing-facebook-btn')
            ->assertVisible('a#sharing-twitter-btn')
            ->screenshot('stepThanks');

        $browser->click('a[href="/members"]')
            ->waitForLocation('/members')
            ->assertPathIs('/members')
            ->assertSee('All members')
            ->screenshot('members');

        $browser->back()
            ->screenshot('back')
            ->click('a#sharing-twitter-btn');

        $windows = $browser->driver->getWindowHandles();
        $browser->driver->switchTo()->window($windows[1]);
        $this->assertSame(parse_url($browser->driver->getCurrentURL(), PHP_URL_HOST), 'x.com');
        $browser->screenshot('twitter')
            ->driver->switchTo()->window($windows[0]);

        $browser->waitForLocation('/register/steps/thanks')
            ->assertPathIs('/register/steps/thanks')
            ->click('a#sharing-facebook-btn');
        $windows = $browser->driver->getWindowHandles();
        $browser->driver->switchTo()->window($windows[2]);

        $this->assertSame(parse_url($browser->driver->getCurrentURL(), PHP_URL_HOST), 'www.facebook.com');
        $browser->screenshot('facebook')
            ->driver->switchTo()->window($windows[0]);
        $browser->click('a[href="/register/start"]')
            ->waitForLocation('/register/steps/one')
            ->assertPathIs('/register/steps/one');
    });
});
