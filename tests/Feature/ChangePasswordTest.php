<?php

use App\Models\Admin;

it('cannot visit change password page if user not logged in', function () {
    $this->get('admin/change-password')->assertRedirect(route('admin.login'));
});

it('can check change password page error', function () {
    adminLogin();

    $this->post('admin/change-password',[
        'current_password' => '',
        'new_password' => ''
    ])
        ->assertSessionHasErrors(['current_password','new_password']);
});

it('can change password successfully', function () {
    adminLogin();

    $this->post('admin/change-password',[
        'current_password' => '123456',
        'new_password' => '11111111',
        'new_password_confirmation' => '11111111',
    ])
        ->assertStatus(302);

    $this->post('admin/logout')->assertStatus(302);

    $adminUser = Admin::first();

    $this->post('admin/login',[
        'username' => $adminUser->username,
        'password' => '11111111',
    ])
        ->assertRedirect(route('admin.dashboard'));
});
