@extends('admin.layouts.guest')

@section('title', __('Login'))

@section('content')
    <form method="post">
        @csrf

        <a class="f-logo text-center">
            <img src="{{ asset('/images/logo-black.png') }}" alt="LOGO">
        </a>

        <div class="login-head">
            <h2 class="title1 text-center">{{ __('Sign In') }}</h2>
        </div>

        @include('admin.layouts.include.errors')

        <div class="form-input">
            <label>
                {{ __('Username') }}
                <input type="text" name="username" placeholder="@lang('Username')" value="admin" required>
            </label>
        </div>

        <div class="form-input">
            <label>
                {{ __('Password') }}
                <input type="password" name="password" placeholder="@lang('Password')" value="123456" required>
            </label>
        </div>

        <div class="checkbox checkbox-container">
            <div class="checkbox">
                <input name="remember" type="checkbox" id="checkbox" class="styled">
                <label for="checkbox">{{ __(' Keep me logged in') }}</label>
            </div>

            <span class="psw">
                <a href="{{ route('admin.password.request')}}">{{ __('Forgot Password?') }}</a>
            </span>
        </div>

        <button type="submit" class="btn-login">{{ __('Sign In') }}</button>
    </form>
@endsection
