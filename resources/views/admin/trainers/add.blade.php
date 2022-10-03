@extends('admin.layouts.app', ['page' => 'trainers'])

@section('title', __('Add New Trainer'))

@section('content')
    <div class="main-content">
        @include('admin.trainers.form', [
            'route' => route('admin.trainers.store'),
            'method' => '',
        ])
    </div>
@endsection
