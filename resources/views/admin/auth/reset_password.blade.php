@extends('admin.layouts.guest')

@section('title', __('Reset Password'))

@section('content')
    <form method="post" action="{{ route('admin.password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <a class="f-logo text-center">
            <img src="{{ asset('/images/logo-black.png') }}" alt="LOGO"/>
        </a>

        <div class="login-head">
            <h2 class="title1 text-center">{{ __('Reset Password') }}</h2>
        </div>

        @include('admin.layouts.include.errors')

        <div class="form-input">
            <label>
                {{ __('Email') }}
                <input type="email"
                    name="email"
                    value="{{ $email ?? old('email') }}"
                    placeholder="{{ __('Email address') }}"
                    required
                    autofocus
                >
            </label>
        </div>

        <div class="form-input">
            <label>
                {{ __('Password') }}
                <input type="password"
                    name="password"
                    placeholder="{{ __('New Password') }}"
                    required
                >
            </label>
        </div>

        <div class="form-input">
            <label>
                {{ __('Confirm Password') }}
                <input type="password"
                    name="password_confirmation"
                    placeholder="{{ __('New Password') }}"
                    required
                >
            </label>
        </div>

        <button type="submit" class="btn-login">{{ __('Reset Password') }}</button>
    </form>
@endsection
