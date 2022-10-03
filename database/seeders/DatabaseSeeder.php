<?php
namespace Database\Seeders;

use App\Models\Member;
use App\Models\MembershipPlan;
use App\Models\Payment;
use App\Models\Timing;
use App\Models\Trainer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Member::factory()->count(50)->create();

        $this->seedMembershipPlans();

        Trainer::factory()->count(10)->create();

        $this->seedTimings();

        Payment::factory()->count(20)->create();
    }

    private function seedMembershipPlans()
    {
        $memberPlans = [
            [ 'name' => 'Monthly', 'price' => '3000', 'plan' => '1' ],
            [ 'name' => 'Special Monthly', 'price' => '4000', 'plan' => '1' ],
            [ 'name' => 'Quarterly', 'price' => '8000', 'plan' => '2' ],
            [ 'name' => 'Special Quarterly', 'price' => '10000', 'plan' => '2' ],
            [ 'name' => 'Half Yearly', 'price' => '15000', 'plan' => '3' ],
            [ 'name' => 'Special Half Yearly', 'price' => '18000', 'plan' => '3' ],
            [ 'name' => 'Yearly', 'price' => '20000', 'plan' => '4' ],
            [ 'name' => 'Special Yearly', 'price' => '25000', 'plan' => '4' ]
        ];

        foreach ($memberPlans as $memberPlan) {
            MembershipPlan::factory()->create($memberPlan);
        }
    }

    private function seedTimings()
    {
        $planOptionKeys = array_keys(Timing::getTimingOptions());

        foreach ($planOptionKeys as $key => $value) {
            if ($key %2 == 0 && sizeof($planOptionKeys)-2 > $key) {
                $timings = Timing::factory()->create([
                    'start_time' => $planOptionKeys[$key],
                    'end_time' => $planOptionKeys[$key+2],
                ]);
            }
        }
    }
}
