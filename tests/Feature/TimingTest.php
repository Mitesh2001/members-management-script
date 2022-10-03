<?php

use App\Models\Member;
use App\Models\Timing;
use App\Models\Trainer;

it('cannot visit timing page if user not logged in', function () {
    $this->get('admin/timings')->assertRedirect(route('admin.login'));
});

it('can check add new timing error', function () {
    adminLogin();

    $this->post('admin/timings',[
        'start_time' => '',
        'end_time' => '',
    ])
    ->assertSessionHasErrors(['start_time','end_time']);

    $this->post('admin/timings',[
        'start_time' => '05:00:00',
        'end_time' => '04:00:00',
    ])
    ->assertStatus(302);
});

it('can add new timing', function () {
    adminLogin();

    $this->post('admin/timings',[
        'start_time' => '05:00:00',
        'end_time' => '06:00:00'
    ])
    ->assertStatus(302);

    expect(Timing::count())->toBe(1);
});

it('can add timing with member and trainer', function () {
    adminLogin();

    expect(Timing::count())->toBe(0);

    $member = Member::factory()->create();
    $trainer = Trainer::factory()->create();

    $this->post('admin/timings',[
        'start_time' => '05:00:00',
        'end_time' => '06:00:00',
        'trainers' => [$trainer->id],
        'members' => [$member->id]
    ])
    ->assertStatus(302);

    expect(Timing::count())->toBe(1);
    expect($member->timings()->count())->toBe(1);
    expect($trainer->timings()->count())->toBe(1);
});

it('can update timing with member and trainer', function () {
    adminLogin();
    $member = Member::factory()->create();
    $trainer = Trainer::factory()->create();

    $timing = Timing::factory()->create([
        'start_time' => '05:00:00',
        'end_time' => '06:00:00'
    ]);

    $member2 = Member::factory()->create();
    $trainer2 = Trainer::factory()->create();

    $this->put('admin/timings/'.$timing->id,[
        'start_time' => '07:00:00',
        'end_time' => '08:00:00',
        'trainers' => [$trainer2->id],
        'members' => [$member2->id]
    ])
    ->assertStatus(302);

    expect(Timing::count())->toBe(1);

    $timing->refresh();
    expect($member2->timings()->count())->toBe(1);
    expect($trainer2->timings()->count())->toBe(1);

    expect($timing)
        ->start_time->toEqual('07:00:00')
        ->end_time->toEqual('08:00:00');
});

it('can delete timing', function () {
    adminLogin();
    $timing = Timing::factory()->create();
    expect(Timing::count())->toBe(1);
    $this->delete('admin/timings/'.$timing->id)->assertStatus(302);
    expect(Timing::count())->toBe(0);
});

it('can delete timing with member and trainer', function () {
    adminLogin();

    $member = Member::factory()->create();
    $trainer = Trainer::factory()->create();
    $timing = Timing::factory()->create();

    expect($member->timings()->count())->toBe(1);
    expect($trainer->timings()->count())->toBe(1);
    expect(Timing::count())->toBe(1);

    $this->delete('admin/timings/'.$timing->id)->assertStatus(302);

    expect(Timing::count())->toBe(0);
    expect($member->timings()->count())->toBe(0);
    expect($trainer->timings()->count())->toBe(0);
});
