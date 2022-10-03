<?php

it('cannot visit top referrer if user not logged in', function () {
    $this->get('admin/top-referrers')->assertRedirect(route('admin.login'));
});

it('can check visit top referrer page', function () {
    adminLogin();
    $this->get('admin/top-referrers')->assertSuccessful();
});
