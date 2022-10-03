<?php

use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\MemberMeasurementController;
use Illuminate\Support\Facades\Route;

Route::resource('/members', MemberController::class);
Route::get('/members-list', [MemberController::class, 'datatables'])
    ->name('members.list')
;
Route::post('/member-detail', [MemberController::class, 'memberDetail'])
    ->name('member.detail')
;
Route::post('/member-upload', [MemberController::class, 'uploadMember'])
    ->name('members.uploads')
;
Route::post('/members/{member}/remove-identification-proof/{media}', [MemberController::class, 'removeMedia'])
    ->name('members.remove-media')
;
Route::get('/member-payments/{id}', [MemberController::class, 'payments'])
    ->name('members.payments')
;
Route::get('/member-measurement/{id}', [MemberMeasurementController::class, 'index'])
    ->name('members.measurements')
;
Route::post('/member-measurement', [MemberMeasurementController::class, 'store'])
    ->name('member-measurement.store')
;
Route::post('/member-measurement-list', [MemberMeasurementController::class, 'list'])
    ->name('member-measurement.list')
;
Route::post('/member-measurement-update', [MemberMeasurementController::class, 'update'])
    ->name('member-measurement.update')
;
Route::post('/member-measurement-delete', [MemberMeasurementController::class, 'destroy'])
    ->name('member-measurement.delete')
;
