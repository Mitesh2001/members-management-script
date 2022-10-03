<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\Timing;
use App\Models\Trainer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timing>
 */
class TimingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        return [
            'start_time' => array_rand(Timing::getTimingOptions()),
            'end_time' => array_rand(Timing::getTimingOptions()),
            'notes' => $this->faker->paragraph,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($timing) {
            $members = Member::select('id')->inRandomOrder()->take(rand(3, 8))->get();
            $trainers = Trainer::select('id')->inRandomOrder()->take(rand(1, 3))->get();

            $timing->members()->attach($members);
            $timing->trainers()->attach($trainers);
        });
    }
}
