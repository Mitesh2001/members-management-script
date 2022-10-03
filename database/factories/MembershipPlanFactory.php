<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MembershipPlan>
 */
class MembershipPlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'price' => $this->faker->numberBetween($min = 10, $max = 9000),
            'plan' => rand(1, 4),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($membershipPlan) {
            $members = Member::whereNull('membership_plan_id')
                ->inRandomOrder()
                ->take(rand(5, 10))
                ->get()
            ;

            foreach ($members as $member) {
                $member->update(['membership_plan_id'=>$membershipPlan->id]);
            }
        });
    }
}
