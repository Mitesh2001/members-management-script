<?php

use App\Models\Admin;

it('can check admin login page error', function () {
    $this->post('admin/login',[
        'username' => '',
        'password' => ''
    ])
    ->assertInvalid(['username','password']);
});

it('can admin login', function () {
    $admin = Admin::factory()->create([
        'username' => 'admin'
    ]);

    $this->post('admin/login',[
        'username' => $admin->username,
        'password' => '123456'
    ])
    ->assertRedirect(route('admin.dashboard'));
});

it('cannot visit login page if user already logged in', function () {
    adminLogin();
    $this->get('admin/login')->assertRedirect(route('admin.dashboard'));
});

it('check remember login page', function () {
    $admin = Admin::factory()->create([
        'username' => 'admin',
        'remember_token' => null
    ]);

    $this->post('admin/login',[
        'username' => $admin->username,
        'password' => '123456',
        'remember' => 1
    ])
    ->assertRedirect(route('admin.dashboard'));

    $admin->refresh();
    expect($admin)
        ->remember_token->not->toEqual(null);
});
