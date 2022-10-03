@extends('admin.layouts.app', ['page' => 'trainers'])

@section('title', __('Update Trainer'))

@section('content')
    <div class="main-content">
        @include('admin.trainers.form', [
            'route' => route('admin.trainers.update', ['trainer' => $trainer->id]),
            'method' => 'PUT',
        ])
    </div>
@endsection
