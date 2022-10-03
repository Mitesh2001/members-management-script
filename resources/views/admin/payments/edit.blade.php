@extends('admin.layouts.app', ['page' => 'payments'])

@section('title', __('Update Payment'))

@section('content')
    <div class="main-content">
        @include('admin.payments.form', [
            'route' => route('admin.payments.update', ['payment' => $payment->id]),
            'method' => 'PUT',
        ])
    </div>
@endsection
