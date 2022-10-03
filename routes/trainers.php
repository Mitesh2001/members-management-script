<?php

use App\Http\Controllers\Admin\TrainerController;
use Illuminate\Support\Facades\Route;

Route::resource('/trainers', TrainerController::class);
Route::get('/trainers-list', [TrainerController::class, 'datatables'])
    ->name('trainers.list')
;
Route::get('trainer-timings/{id}', [TrainerController::class, 'timings'])
    ->name('trainers.timings')
;
Route::post('/trainers/{trainer}/remove-identification-proof/{media}', [TrainerController::class, 'removeMedia'])
    ->name('trainers.remove-media')
;
