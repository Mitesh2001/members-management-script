<?php

use App\Models\Member;
use App\Models\MemberMeasurement;
use Carbon\Carbon;

it('cannot visit member measurement if user not logged in', function () {
    $this->get('admin/member-measurement/3')->assertRedirect(route('admin.login'));
});

it('can check add new member measurement page error', function () {
    adminLogin();

    $this->post('admin/member-measurement',[
        'measurement_type' => '',
        'measurement_date' => Carbon::now()->addDay(2),
        'measurement_value' => '',
        'member_id' => ''
    ])
    ->assertStatus(302)
    ->assertSessionHasErrors(['measurement_type','measurement_date','measurement_value','member_id']);
});

it('can check add new member measurement', function () {
    adminLogin();
    $member = Member::factory()->create();

    $this->post('admin/member-measurement',[
        'measurement_type' => '1',
        'measurement_date' => '2022-02-21',
        'measurement_value' => '10',
        'member_id' => $member->id
    ])
    ->assertOk();

    $this->assertDatabaseHas('member_measurements', [
        'member_id' => $member->id,
        'measurement_type' => '1',
        'measurement_value' => '10',
        'measurement_date' => '2022-02-21'
    ]);
});

it('can check update member measurement', function () {
    adminLogin();

    $member = Member::factory()->create();
    $memberMeasurement = MemberMeasurement::factory()->create([
        'member_id' => $member->id,
        'measurement_type' => '1',
        'measurement_value' => '20',
        'measurement_date' => '2022-02-01'
    ]);

    $this->post('admin/member-measurement-update',[
        'measurement_type' => '2',
        'measurement_date' => '2022-02-10',
        'measurement_value' => '30',
        'member_id' => $member->id,
        'id' => $memberMeasurement->id
    ])
    ->assertOk();

    $memberMeasurement->refresh();
    expect($memberMeasurement)
        ->measurement_type->toEqual('2')
        ->measurement_date->toEqual('2022-02-10')
        ->measurement_value->toEqual('30.00');
});

it('can check delete member measurement', function () {
    adminLogin();
    expect(MemberMeasurement::count())->toBe(0);
    $member = Member::factory()->create();
    $memberMeasurement = MemberMeasurement::factory()->create();

    $this->post('admin/member-measurement-delete',[
        'id' => $memberMeasurement->id
    ])
    ->assertOk();

    $this->assertModelMissing($memberMeasurement);
});
