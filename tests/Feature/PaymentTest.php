<?php

use App\Models\Member;
use App\Models\Payment;

it('cannot visit payment page if user not logged in', function () {
    $this->get('admin/payments')->assertRedirect(route('admin.login'));
});

it('can check add new payment error', function () {
    adminLogin();

    $this->post('admin/payments',[
        'member_id' => '',
        'payment_date' => '',
        'amount' => ''
    ])
    ->assertSessionHasErrors(['member_id','payment_date','amount']);
});

it('can check add new payment', function () {
    adminLogin();
    $member = Member::factory()->create();

    $this->post('admin/payments',[
        'member_id' => $member->id,
        'payment_date' => '2020-01-01',
        'amount' => '100'
    ])
    ->assertStatus(302);

    $this->assertDatabaseHas('payments', [
        'member_id' => $member->id,
        'payment_date' => '2020-01-01',
        'amount' => '100.00'
    ]);
});

it('can check update payment', function () {
    adminLogin();
    $member = Member::factory()->create();

    $payment = Payment::factory()->create([
        'member_id' => $member->id,
        'payment_date' => '2020-01-02',
        'amount' => '5620'
    ]);

    $this->put('admin/payments/'.$payment->id,[
        'member_id' => $member->id,
        'payment_date' => '2022-01-02',
        'amount' => '2542'
    ])
    ->assertStatus(302);

    $payment->refresh();
    expect($payment)
        ->member_id->toEqual($member->id)
        ->payment_date->toEqual('2022-01-02')
        ->amount->toEqual('2542.00');
});

it('can delete payment', function () {
    adminLogin();
    $member = Member::factory()->create();
    $payment = Payment::factory()->create();

    $this->delete('admin/payments/'.$payment->id)
        ->assertSessionHasNoErrors();

    $this->assertModelMissing($payment);
});
