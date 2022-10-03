@extends('admin.layouts.guest')

@section('title', __('Forgot Password'))

@section('content')
    <form action="{{ route('admin.password.email') }}" method="post">
        @csrf

        <a class="f-logo text-center">
            <img src="{{ asset('/images/logo-black.png') }}" alt="LOGO">
        </a>

        <div class="login-head">
            <h2 class="title1 text-center">{{__('Forgot Password')}}</h2>
        </div>

        @include('admin.layouts.include.errors')

        <div class="form-input">
            <label>
                {{ __('Email') }}
                <input type="text"
                    name="email"
                    placeholder="{{ __('Email address') }}"
                    value="{{ old('email') }}"
                    required
                    autofocus
                >
            </label>
        </div>

        <button type="submit" class="btn-login">{{ __('Send Password Reset Link') }}</button>

        <div class="checkbox checkbox-container pull-right">
            <span class="psw">
                <a href="{{ route('admin.login')}}">{{ __('Back to Login') }}</a>
            </span>
        </div>
    </form>
@endsection
