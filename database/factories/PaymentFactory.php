<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'member_id' => Member::inRandomOrder()->value('id'),
            'amount' => $this->faker->numberBetween($min = 10, $max = 9000),
            'payment_date' => mt_rand(0, 1) ? $this->faker->date : $this->faker->dateTimeBetween(
                $startDate = '-30 days',
                $endDate = 'now'
            ),
            'new_validity_date' => $this->faker->date,
            'status' => 3, //For paid
            'created_at' => $this->faker->dateTimeBetween(
                $startDate = '-60 days',
                $endDate = 'now'
            ),
        ];
    }
}
