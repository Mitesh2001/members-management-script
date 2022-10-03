<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\MemberMeasurement;

use Illuminate\Database\Eloquent\Factories\Factory;

class MemberMeasurementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MemberMeasurement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'member_id' => Member::factory()->create()->id,
            'measurement_type' => rand(1, 6),
            'measurement_value' => $this->faker->numberBetween($min = 10, $max = 100),
            'measurement_date' => $this->faker->dateTimeBetween(
                $startDate = '-60 days',
                $endDate = '-1 days'
            )
        ];
    }
}
