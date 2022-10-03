<?php

use App\Models\Trainer;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('cannot visit trainer if user not logged in', function () {
    $this->get('admin/trainers')->assertRedirect(route('admin.login'));
});

it('can check add new trainer error', function () {
    adminLogin();

    $this->post('admin/trainers',[
        'first_name' => '',
        'last_name' => '',
        'email' => '',
        'mobile_no' => '',
        'phone' => '',
        'address' => '',
        'gender' => '',
    ])
    ->assertSessionHasErrors(['first_name','last_name','email','mobile_no','gender']);
});

it('can check unique trainer email', function () {
    adminLogin();
    $trainer = Trainer::factory()->create([
        'email' => 'test@gmail.com',
    ]);

    Storage::fake('avatars');
    $identityProofs[] = UploadedFile::fake()->image('id1.jpg');
    $identityProofs[] = UploadedFile::fake()->image('id2.jpg');
    $avatar = UploadedFile::fake()->image('avatar.jpg');

    $this->post('admin/trainers',[
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

it('can check add new trainer', function () {
    adminLogin();

    Storage::fake('avatars');
    $identityProofs[] = UploadedFile::fake()->image('id1.jpg');
    $identityProofs[] = UploadedFile::fake()->image('id2.jpg');
    $avatar = UploadedFile::fake()->image('avatar.jpg');

    $this->post('admin/trainers',[
        'first_name' => 'test',
        'last_name' => 'test',
        'email' => 'test@gmail.com',
        'phone' => '125445555',
        'mobile_no' => '55555555',
        'address' => 'test',
        'gender' => 1,
        'identity_proofs' => $identityProofs,
        'avatar' => $avatar
    ])
    ->assertStatus(302);

    expect(Trainer::count())->toBe(1);
});

it('can check update trainer', function () {
    adminLogin();

    $trainer = Trainer::factory()->create([
        'first_name' => 'test first',
        'last_name' => 'test last',
        'email' => 'test@gmail.com',
        'phone' => '125445555',
        'mobile_no' => '55555555',
        'address' => 'test address',
        'gender' => 1
    ]);

    Storage::fake('avatars');
    $identityProofs[] = UploadedFile::fake()->image('id1.jpg');
    $identityProofs[] = UploadedFile::fake()->image('id2.jpg');
    $avatar = UploadedFile::fake()->image('avatar.jpg');

    $this->put('admin/trainers/'.$trainer->id,[
        'first_name' => 'test 123',
        'last_name' => 'test last 123',
        'email' => 'test123@gmail.com',
        'phone' => '111111',
        'mobile_no' => '222222',
        'address' => 'test address 123',
        'gender' => 2,
        'identity_proofs' => $identityProofs,
        'avatar' => $avatar
    ])
    ->assertStatus(302);

    $trainer->refresh();
    expect($trainer)
        ->first_name->toEqual('test 123')
        ->last_name->toEqual('test last 123')
        ->email->toEqual('test123@gmail.com')
        ->phone->toEqual('111111')
        ->mobile_no->toEqual('222222')
        ->address->toEqual('test address 123')
        ->gender->toEqual('2');
});

it('can delete trainer', function () {
    adminLogin();
    $trainer = Trainer::factory()->create();
    $this->delete('admin/trainers/'.$trainer->id)->assertStatus(302);
    $this->assertSoftDeleted($trainer);
});
