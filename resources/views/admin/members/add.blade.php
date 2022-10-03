@extends('admin.layouts.app', ['page' => 'members'])

@section('title', __('Add New Member'))

@section('content')
    <div class="main-content">
        @include('admin.members.form', [
            'route' => route('admin.members.store'),
            'method' => '',
        ])
    </div>
@endsection
