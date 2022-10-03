@extends('admin.layouts.app', ['page' => 'membership-plans'])

@section('title', __('Add New Membership Plan'))

@section('content')
    <div class="main-content">
        @include('admin.membership_plans.form', [
            'route' => route('admin.membership-plans.store'),
            'method' => '',
        ])
    </div>
@endsection
