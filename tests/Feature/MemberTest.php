<?php

use App\Models\Member;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('cannot visit member page if user not logged in', function () {
    $this->get('admin/members')->assertRedirect(route('admin.login'));
});

it('can check add new member error', function () {
    adminLogin();

    $this->post('admin/members',[
        'first_name' => '',
        'last_name' => '',
        'date_of_birth' => '',
        'email' => '',
        'member_since' => '',
        'phone' => '',
        'emergency_number' => '',
        'address' => '',
        'status' => '',
        'gender' => '',
        'height' => '',
        'validity_date' => ''
    ])
    ->assertSessionHasErrors(['first_name','last_name','email','phone','emergency_number','status','member_since','validity_date']);
});

it('can check unique member email', function () {
    adminLogin();
    $trainer = Member::factory()->create([
        'email' => 'test@gmail.com',
    ]);

    Storage::fake('avatars');
    $identityProofs[] = UploadedFile::fake()->image('id1.jpg');
    $identityProofs[] = UploadedFile::fake()->image('id2.jpg');
    $avatar = UploadedFile::fake()->image('avatar.jpg');

    $this->post('admin/members',[
        'first_name' => 'test 1',
        'last_name' => 'test 1',
        'email' => 'test@gmail.com',
        'phone' => '252555',
        'mobile_no' => '52245',
        'address' => 'test address',
        'gender' => 1,
        'identity_proofs' => $identityProofs,
        'avatar' => $avatar
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors('email');
});

it('can add new member', function () {
    adminLogin();

    Storage::fake('avatars');
    $identityProofs[] = UploadedFile::fake()->image('id1.jpg');
    $identityProofs[] = UploadedFile::fake()->image('id2.jpg');
    $avatar = UploadedFile::fake()->image('avatar.jpg');

    $this->post('admin/members',[
        'first_name' => 'test',
        'last_name' => 'test',
        'date_of_birth' => '2000-01-11',
        'email' => 'test@gmail.com',
        'member_since' => '2020-01-11',
        'phone' => '125445555',
        'emergency_number' => '55555555',
        'address' => 'test',
        'status' => 1,
        'gender' => 1,
        'height' => 20,
        'validity_date' => '2023-01-01',
        'identity_proofs' => $identityProofs,
        'avatar' => $avatar
    ])
    ->assertStatus(302);

    expect(Member::count())->toBe(1);
});

it('can member import', function () {
    adminLogin();

    $memberFile = new UploadedFile(
        base_path('/public/xlsx/member_format.xlsx'),
        'member_format.xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        null,
        true
    );

    $this->post('admin/member-upload',[
        'members' => $memberFile
    ])
    ->assertStatus(302);

    expect(Member::count())->toBe(1);
});

it('can update member', function () {
    adminLogin();

    $member = Member::factory()->create([
        'first_name' => 'test',
        'last_name' => 'test',
        'date_of_birth' => '2000-01-11',
        'email' => 'test@gmail.com',
        'member_since' => '2020-01-11',
        'phone' => '125445555',
        'emergency_number' => '55555555',
        'address' => 'test',
        'status' => 1,
        'gender' => 1,
        'height' => 20,
        'validity_date' => '2023-01-01',
    ]);

    Storage::fake('avatars');
    $identityProofs[] = UploadedFile::fake()->image('id1.jpg');
    $identityProofs[] = UploadedFile::fake()->image('id2.jpg');
    $avatar = UploadedFile::fake()->image('avatar.jpg');

    $this->put('admin/members/'.$member->id,[
        'first_name' => 'test 123',
        'last_name' => 'test last 123',
        'date_of_birth' => '2002-01-11',
        'email' => 'test123@gmail.com',
        'member_since' => '2019-01-11',
        'phone' => '111111',
        'emergency_number' => '222222',
        'address' => 'test address 123',
        'status' => 0,
        'gender' => 2,
        'height' => 5,
        'validity_date' => '2022-01-01',
        'identity_proofs' => $identityProofs,
        'avatar' => $avatar
    ])
    ->assertStatus(302);

    $member->refresh();
    expect($member)
        ->first_name->toEqual('test 123')
        ->last_name->toEqual('test last 123')
        ->date_of_birth->toEqual('2002-01-11')
        ->email->toEqual('test123@gmail.com')
        ->member_since->toEqual('2019-01-11')
        ->phone->toEqual('111111')
        ->emergency_number->toEqual('222222')
        ->address->toEqual('test address 123')
        ->status->toEqual('0')
        ->gender->toEqual('2')
        ->height->toEqual('5')
        ->validity_date->toEqual('2022-01-01');
});

it('can delete member', function () {
    adminLogin();
    $member = Member::factory()->create();
    $this->delete('admin/members/'.$member->id)->assertStatus(302);
    $this->assertSoftDeleted($member);
});

it('can not delete member if have referents', function () {
    adminLogin();

    $member = Member::factory()->create();
    $member2 = Member::factory()->create();

    $this->delete('admin/members/'.$member->id)->assertStatus(302);

    $this->assertDatabaseHas('members', [
        'id' => $member->id,
        'deleted_at' => NULL,
        'id' => $member2->id,
        'deleted_at' => NULL
    ]);
});

it('can visit member payments page', function () {
    adminLogin();
    $member = Member::factory()->create();
    $this->get('admin/member-payments/'.$member->id)->assertOk();
});
