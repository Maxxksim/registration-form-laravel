<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Symfony\Component\Intl\Countries;

/**
 * @extends Factory<Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'birthdate' => fake()->date('Y-m-d', today()),
            'report_subject' => fake()->realText(255),
            'country' => fake()->randomElement(Countries::getNames('en')),
            'phone' => fake()->e164PhoneNumber(),
            'email' => fake()->email()
        ];
    }
}
