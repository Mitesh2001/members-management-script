<?php

use App\Models\Member;
use App\Models\MembershipPlan;

it('cannot visit membership plan if user not logged in', function () {
    $this->get('admin/membership-plans')->assertRedirect(route('admin.login'));
});

it('can check add new membership plan error', function () {
    adminLogin();

    $this->post('admin/membership-plans',[
        'name' => '',
        'price' => '',
        'plan' => ''
    ])
    ->assertSessionHasErrors(['name','price','plan']);
});

it('can check add new membership plan', function () {
    adminLogin();

    $this->post('admin/membership-plans',[
        'name' => 'Monthly',
        'price' => '10',
        'plan' => '2'
    ])
    ->assertStatus(302);

    $membershipPlan = MembershipPlan::First();
    expect($membershipPlan)
        ->name->toEqual('Monthly')
        ->price->toEqual('10')
        ->plan->toEqual('2');
});

it('can check update membership plan', function () {
    adminLogin();

    $membershipPlan = MembershipPlan::factory()->create([
        'name' => 'Monthly Membership Plan',
        'price' => '58250',
        'plan' => '2'
    ]);

    $this->put('admin/membership-plans/'.$membershipPlan->id,[
        'name' => 'Quarterly Membership Plan',
        'price' => '5264',
        'plan' => '4'
    ])
    ->assertStatus(302);

    $membershipPlan->refresh();
    expect($membershipPlan)
        ->name->toEqual('Quarterly Membership Plan')
        ->price->toEqual('5264')
        ->plan->toEqual('4');
});

it('can check delete membership plan', function () {
    adminLogin();
    $membershipPlan = MembershipPlan::factory()->create();
    $this->delete('admin/membership-plans/'.$membershipPlan->id)->assertStatus(302);
    expect(MembershipPlan::count())->toBe(0);
});

it('can not delete membership plans with member', function () {
    adminLogin();
    $membershipPlan = MembershipPlan::factory()->create();

    $member = Member::factory()->create([
        'membership_plan_id' => $membershipPlan->id
    ]);

    $this->delete('admin/membership-plans/'.$membershipPlan->id)->assertStatus(302);

    $this->assertModelExists($membershipPlan);
});
