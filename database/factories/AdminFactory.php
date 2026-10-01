<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Admin>
 */
class AdminFactory extends Factory
{

    public function definition(): array
    {
        return [
            'username' => 'admin',
            'password' => Hash::make('admin')
        ];
    }
}
