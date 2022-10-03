<?php

use App\Models\Member;
use Illuminate\Support\Facades\Mail;
use App\Mail\MemberMail;

it('cannot visit send mail page if user not logged in', function () {
    $this->get('admin/member-mail')
        ->assertRedirect(route('admin.login'));
});

it('can check mail send for all member error', function () {
    adminLogin();

    $this->post('admin/member-mail',[
        'member_type' => '',
        'member' => '',
        'subject' => '',
        'content' => ''
    ])
    ->assertSessionHasErrors(['member_type','subject','content']);
});

it('can check mail send selected member error', function () {
    adminLogin();

    $this->post('admin/member-mail',[
        'member_type' => 'selected',
        'member' => '',
        'subject' => '',
        'content' => ''
    ])
    ->assertSessionHasErrors(['member','subject','content']);
});

it('can check send mail selected member', function () {
    adminLogin();
    $member = Member::factory()->create();
    Mail::fake();

    $this->post('admin/member-mail',[
        'member_type' => 'selected',
        'member' => array($member->id),
        'subject' => 'Test only',
        'content' => 'Test Mail send'
    ])
    ->assertStatus(302);

    Mail::assertSent(MemberMail::class);
});

it('can check send mail all member', function () {
    adminLogin();
    $member = Member::factory(5)->create();
    Mail::fake();

    $this->post('admin/member-mail',[
        'member_type' => 'all',
        'subject' => 'Test only',
        'content' => 'Test Mail send'
    ])
    ->assertStatus(302);

    Mail::assertSent(MemberMail::class,5);
});
