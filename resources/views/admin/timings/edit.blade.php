@extends('admin.layouts.app', ['page' => 'timings'])

@section('title', __('Update Timing'))

@section('content')
    <div class="main-content">
        @include('admin.timings.form', [
            'route' => route('admin.timings.update', ['timing' => $timing->id]),
            'method' => 'PUT',
        ])
    </div>
@endsection
