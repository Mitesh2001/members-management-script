<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        Member::inRandomOrder()->value('id');
        return [
            'first_name' => $this->faker->firstname,
            'last_name' => $this->faker->lastname,
            'date_of_birth' => $this->faker->date,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'member_since' => $this->faker->date,
            'phone' => $this->faker->phoneNumber,
            'emergency_number' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'status' => mt_rand(0, 1),
            'gender' => mt_rand(1, 2),
            'height' => $this->faker->numberBetween($min = 10, $max = 100),
            'validity_date' => $this->faker->dateTimeBetween(
                $startDate = '-60 days',
                $endDate = '+1 years'
            ),
            'notes' => $this->faker->paragraph,
            'created_at' => $this->faker->dateTimeBetween(
                $startDate = '-60 days',
                $endDate = 'now'
            ),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($member) {
            $member->referred_by = Member::inRandomOrder()->where('id', '!=', $member->id)->value('id');
            $member->save();
        });
    }
}
