<?php

it ('can check admin logout', function () {
    adminLogin();
    $this->get('admin/login')->assertRedirect(route('admin.dashboard'));
    $this->post('admin/logout')->assertStatus(302);
    $this->get('admin')->assertRedirect(route('admin.login'));
});
