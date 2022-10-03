@extends('admin.layouts.app', ['page' => 'timings'])

@section('title', __('Add New Timing'))

@section('content')
    <div class="main-content">
        @include('admin.timings.form', [
            'route' => route('admin.timings.store'),
            'method' => '',
        ])
    </div>
@endsection
