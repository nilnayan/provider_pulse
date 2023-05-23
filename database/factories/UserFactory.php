<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $access_level_ids = \App\Models\AccessLevel::all()->pluck('id');
        $access_level_idx = rand(0, count($access_level_ids) - 1);

        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('11111111'),
            'phone' => fake()->numerify('###-###-####'),
            'access_level_id' => $access_level_ids[$access_level_idx],
            'department_id' => rand(1, \App\Models\Department::count()),
            'job_title_id' => rand(1, \App\Models\JobTitle::count()),
            'satisfaction_level_id' => rand(1, 5),
            'status_id' => rand(1, \App\Models\EmployeeStatus::count()),
            'start_dt' => fake()->dateTimeThisYear()->format('Y-m-d'),
            'next_review_dt' => fake()->dateTimeBetween(now(), date('Y-m-d', strtotime('+1 year')))->format('Y-m-d'),
            'last_review_dt' => fake()->dateTimeBetween(date('Y-m-d', strtotime('-1 year')), now())->format('Y-m-d'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
