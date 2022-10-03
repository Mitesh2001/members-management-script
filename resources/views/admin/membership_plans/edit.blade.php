@extends('admin.layouts.app', ['page' => 'membership-plans'])

@section('title', __('Update Membership Plan'))

@section('content')
    <div class="main-content">
        @include('admin.membership_plans.form', [
            'route' => route('admin.membership-plans.update',['membership_plan' => $membershipPlan->id ]),
            'method' => 'PUT',
        ])
    </div>
@endsection
