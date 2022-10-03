<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
;
Route::get('/get-expire-membership-member', [DashboardController::class, 'getExpireMembershipMember'])
    ->name('membership_plan_expire_list')
;
