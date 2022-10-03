<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MemberMailController;
use App\Http\Controllers\Admin\MembershipPlanController;
use App\Http\Controllers\Admin\ReferrerController;
use App\Http\Controllers\Admin\TimingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'welcome');

// Admin Route
Route::name('admin.')->prefix('admin')->group(function () {
    Route::redirect('/', '/admin/login');

    Route::group([], base_path('routes/admin_login_logout.php'));

    // Admin Auth route
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::group([], base_path('routes/dashboard.php'));

        Route::group([], base_path('routes/members.php'));

        Route::resource('/membership-plans', MembershipPlanController::class);
        Route::group([], base_path('routes/trainers.php'));

        Route::resource('/timings', TimingController::class);
        Route::get('/timings-list', [TimingController::class, 'datatables'])
            ->name('timings.list')
        ;

        Route::group([], base_path('routes/payments.php'));

        Route::get('/member-mail', [MemberMailController::class, 'index'])
            ->name('member-mail.index')
        ;
        Route::post('/member-mail', [MemberMailController::class, 'sendMail'])
            ->name('member-mail.store')
        ;

        Route::get('/top-referrers', [ReferrerController::class, 'index'])
            ->name('top-referrers.list')
        ;
        Route::get('/referrer-list', [ReferrerController::class, 'datatables'])
            ->name('top-referrers.data_table_list')
        ;

        Route::get('/change-password', [AdminController::class, 'index'])
            ->name('change_password')
        ;
        Route::post('/change-password', [AdminController::class, 'changePassword']);

    });
});
