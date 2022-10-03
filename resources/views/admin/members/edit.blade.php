@extends('admin.layouts.app', ['page' => 'members'])

@section('title', __('Update Member'))

@section('content')
    <div class="main-content">
        @include('admin.members.form', [
            'route' => route('admin.members.update',['member' => $member->id ]),
            'method' => 'PUT',
        ])
    </div>
@endsection
