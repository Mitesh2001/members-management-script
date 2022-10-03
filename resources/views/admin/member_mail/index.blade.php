@extends('admin.layouts.app', ['page' => 'member-mail'])

@section('title', __('Send Mail'))

@push('styles')
    <link property='stylesheet' href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
@endpush

@section('content')
    <div class="main-content">
        <form method="post" action="{{ route('admin.member-mail.store') }}">
            @csrf

            <div class="member-card">
                <div class="d-flex align-items-center justify-content-between mb-20 border-bottom pb-3 flex-wrap">
                    <h2 class="title">{{ __('Send Mail') }}</h2>

                    <div>
                        <button type="reset" class="nav-btn bg-orange color-orange mr-3">
                            {{ __('Reset') }}
                        </button>

                        <button type="submit" class="nav-btn bg-blue color-blue">
                            {{ __('Submit') }}
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="form-input col-12 col-lg-6">
                        <div class="label">
                            {{ __('To') }}
                            <span class="d-flex align-items-center pt-1">
                                <span class="radio">
                                    <input id="radio-selected"
                                        name="member_type"
                                        type="radio"
                                        value="selected"
                                        checked
                                    >
                                    <label for="radio-selected" class="radio-label d-flex align-items-center">
                                        {{ __('Selected Members') }}
                                    </label>
                                </span>

                                <span class="radio ml-5">
                                    <input id="radio-all"
                                        name="member_type"
                                        type="radio"
                                        value="all"
                                        {{ old("member_type") == "all" ? "checked" : ""}}
                                    >
                                    <label for="radio-all" class="radio-label d-flex align-items-center">
                                        {{ __('All Members') }}
                                    </label>
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="form-group select-member mail-select-member">
                            <label>{{ __('Select member') }}</label>

                            <select name="member[]"
                                class="chosen-select"
                                data-placeholder="@lang('Select Member')"
                                multiple
                            >
                                @foreach ($members as $member)
                                    <option value="{{ $member->id }}">
                                        {{ $member->getName() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-input col-12">
                        <label>
                            {{ __('Subject') }}
                            <input type="text"
                                name="subject"
                                value="{{ old('subject') }}"
                                placeholder="Enter Subject"
                                value="{{ old('subject') }}"
                                required
                            >
                        </label>
                    </div>

                    <div class="form-input col-12">
                        <label class="textarea-label">
                            {{ __('Content') }}
                            <textarea name="content" cols="50" rows="10" id="content" required>{{ old('content') }}</textarea>

                            <p class="mt-3">
                                <span id="add-first-name" class="badge badge-secondary pointer">[[first_name]]</span>

                                <span id="add-last-name" class="badge badge-secondary pointer">[[last_name]]</span>

                                <span id="add-email" class="badge badge-secondary pointer">[[email]]</span>

                                <span id="add-phone" class="badge badge-secondary pointer">[[phone]]</span>
                            </p>
                        </label>
                    </div>

                    <div class="form-input col-12 my-5">
                        <button type="reset" class="nav-btn bg-orange color-orange mr-3">
                            {{ __('Reset') }}
                        </button>

                        <button type="submit" class="nav-btn bg-blue color-blue">
                            {{ __('Submit') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
    <script>
        $(function () {
            $(".chosen-select").chosen();

            $('#add-first-name, #add-last-name, #add-email, #add-phone').click(function () {
                $('#content').val($('#content').val() + $(this).html() + " ");
            });

            $("input[name='member_type']").change(function () {
                $(".select-member").removeClass('d-none');

                if (this.value === 'all') {
                    $(".select-member").addClass('d-none');
                }
            });
        })
    </script>
@endpush
