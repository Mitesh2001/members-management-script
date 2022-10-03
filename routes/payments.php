<?php

use App\Http\Controllers\Admin\PaymentController;
use Illuminate\Support\Facades\Route;

Route::resource('/payments', PaymentController::class);
Route::get('/payments-list', [PaymentController::class, 'datatables'])
    ->name('payments.list')
;
Route::get('/payments-online', [PaymentController::class, 'onlinePaymentForm'])
    ->name('payments.online')
;
Route::post('/payments-online', [PaymentController::class, 'onlinePayment']);
Route::get('/payment-invoice/{payment}', [PaymentController::class, 'paymentInvoice'])
    ->name('payment.invoice')
;
Route::post('/stripe-payment-response', [PaymentController::class, 'stripePaymentResponse'])
    ->name('payments-online.response')
;
Route::match(['get', 'post'], '/payments-report', [PaymentController::class, 'paymentsReport'])
    ->name('payments.report')
;
