<?php

use App\Models\Member;
use App\Models\Payment;
use App\Models\Trainer;
use Carbon\Carbon;

it('cannot visit dashboard if user not logged in', function () {
    $this->get('admin/dashboard')->assertRedirect(route('admin.login'));
});

it('can check total members on dashboard page', function () {
    adminLogin();

    Member::factory(13)->create([
        'created_at' => Carbon::now()
    ]);

    Member::factory(8)->create([
        'created_at' => Carbon::now()->subMonth()
    ]);

    $this->get('admin/dashboard')
        ->assertSee(13)
        ->assertSee('63 %');
});

it('can check total active members on dashboard page', function () {
    adminLogin();

    Member::factory(13)->create([
        'validity_date' => Carbon::now()->addDay(20)
    ]);

    Member::factory(5)->create([
        'validity_date' => Carbon::now()->subDay(10)
    ]);

    $this->get('admin/dashboard')->assertSee(13);
});

it('can check total trainers members on dashboard page', function () {
    adminLogin();
    Trainer::factory(13)->create();
    $this->get('admin/dashboard')->assertSee(13);
});

it('can check total payments on dashboard page', function () {
    adminLogin();

    Member::factory(5)->create([
        'created_at' => Carbon::now()->subMonth()
    ]);

    Payment::factory(10)->create([
        'amount' => 356,
        'created_at' => Carbon::now()
    ]);

    Payment::factory(5)->create([
        'amount' => 500,
        'created_at' => Carbon::now()->subMonth()
    ]);

    $this->get('admin/dashboard')
        ->assertSee("3,560.00")
        ->assertSee('42 %');
});

it('can check success payment list on dashboard page', function () {
    adminLogin();

    $member = Member::factory()->create([
        'first_name' => 'first test 1',
        'last_name' => 'Last test 1',
    ]);

    Payment::factory()->create([
        'amount' => 525,
        'member_id' => $member->id,
        'created_at' => Carbon::now(),
        'payment_date' => '2022-02-20'
    ]);

    $member = Member::factory()->create([
        'first_name' => 'first test 2',
        'last_name' => 'Last test 2',
    ]);

    Payment::factory()->create([
        'amount' => 3568,
        'member_id' => $member->id,
        'created_at' => Carbon::now(),
        'payment_date' => '2022-02-14'
    ]);

    $this->get('admin/dashboard')
        ->assertSee("first test 1 Last test 1")
        ->assertSee("20-02-2022")
        ->assertSee("525.00")
        ->assertSee("first test 2 Last test 2")
        ->assertSee("14-02-2022")
        ->assertSee("3568.00");
});
