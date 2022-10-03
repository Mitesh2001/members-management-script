<?php

it('cannot visit payments report if user not logged in', function () {
    $this->get('admin/payments-report')->assertRedirect(route('admin.login'));
});

it('can check visit payments report page', function () {
    adminLogin();
    $this->get('admin/payments-report')->assertSuccessful();
});
