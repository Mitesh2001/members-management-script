@extends('admin.layouts.app', ['page' => 'change_password'])

@section('title', __('Change Password'))

@section('content')
    <form method="post" action="{{ route('admin.change_password') }}">
        @csrf

        <div class="main-content">
            <div class="member-card">
                <div class="d-flex align-items-center justify-content-between mb-20 border-bottom pb-3 flex-wrap">
                    <div class="title-main">
                        <h2 class="title">{{ __('Change Password') }}</h2>
                    </div>

                    <div class="button-main">
                        <button type="reset" class="nav-btn bg-orange color-orange mr-3">
                            {{ __('Reset') }}
                        </button>

                        <button type="submit" class="nav-btn bg-blue color-blue">{{ __('Submit') }}</button>
                    </div>
                </div>

                <div class="row">
                    <div class="form-input col-12">
                        <label>
                            {{ __('Current Password') }}
                            <input name="current_password"
                                type="password"
                                placeholder="{{ __('Enter Current Password') }}"
                                required
                            >
                        </label>
                    </div>

                    <div class="form-input col-6">
                        <label>
                            {{ __('New Password') }}
                            <input name="new_password"
                                type="password"
                                placeholder="{{ __('Enter New Password') }}"
                                required
                            >
                        </label>
                    </div>

                    <div class="form-input col-6">
                        <label>
                            {{ __('Confirm New Password') }}
                            <input name="new_password_confirmation"
                                type="password"
                                placeholder="{{ __('Confirm New Password') }}"
                                required
                            >
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
