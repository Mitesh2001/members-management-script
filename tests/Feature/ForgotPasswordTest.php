<?php

use App\Models\Admin;
use Illuminate\Support\Facades\Password;

it('cannot visit forgot password page if user already logged in', function () {
    adminLogin();
    $this->get('admin/password/reset')->assertRedirect(route('admin.dashboard'));
});

it('can check forgot password error', function () {
    $this->post('admin/password/email',[
        'email' => '',
    ])
    ->assertSessionHasErrors(['email']);
});

it('can send mail for forget password', function () {
    $admin = Admin::factory()->create([
        'email' => 'test@gmail.com'
    ]);

    $this->post('admin/password/email',[
        'email' => $admin->email,
    ])
    ->assertStatus(302);

    $this->assertDatabaseHas('admin_password_resets', [
        'email' => $admin->email
    ]);
});

it('can check reset link page error', function () {
    $this->post('admin/password/reset',[
        'email' => 'test@gmail.com'
    ])
    ->assertSessionHasErrors('token','password');
});

it('can reset the forget password', function () {
    $admin = Admin::factory()->create([
        'email' => 'test@gmail.com',
        'username' => 'admin'
    ]);

    $token = Password::createToken($admin);

    $this->post('admin/password/reset',[
        'email' => $admin->email,
        'password' => '11111111',
        'password_confirmation' => '11111111',
        'token' => $token
    ])
    ->assertStatus(302);

    $this->post('admin/login',[
        'username' => $admin->username,
        'password' => '11111111',
    ])
    ->assertRedirect(route('admin.dashboard'));
});
