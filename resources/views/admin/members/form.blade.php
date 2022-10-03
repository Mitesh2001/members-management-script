@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/flatpickr/dist/flatpickr.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">

    <link rel="stylesheet" href="https://www.jqueryscript.net/demo/Bootstrap-4-Dropdown-Select-Plugin-jQuery/dist/css/bootstrap-select.css">
@endpush

<form method="post" action="{{ $route }}" enctype="multipart/form-data">
    @csrf

    @if ($method)
        @method($method)
    @endif

    <div class="member-card">
        <div class="d-flex align-items-center justify-content-between mb-20 border-bottom pb-3 flex-wrap">
            <div class="title-main">
                <h2 class="title">{{ $method ? __('Update Member') : __('Add New Member') }}</h2>
            </div>

            <div class="button-main">
                <a href="{{ route('admin.members.index') }}">
                    <button type="button" class="nav-btn bg-red color-red mr-3">
                        {{ __('Cancel') }}
                    </button>
                </a>

                <button type="submit" class="nav-btn bg-blue color-blue">
                    {{ $method ? __('Update') : __('Submit') }}
                </button>
            </div>
        </div>

        <div class="head">{{ __('Personal Details') }}</div>

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="avatar-upload">
                    <div class="avatar-edit">
                        <input type="file"
                            name="avatar"
                            id="member-image-upload"
                            accept=".png, .jpg, .jpeg"
                        >
                        <label for="member-image-upload"></label>
                    </div>

                    <div class="avatar-preview">
                        <div id="image-preview"
                            style="background-image: url({{ $method ? getAvatarUrl($member, 'members', 'thumb') : asset('images/avatar.png') }});">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 pt-4">
                <div class="upload-file">
                    <input type="file"
                        name="identity_proofs[]"
                        id="identity-proofs"
                        accept=".png, .jpg, .jpeg"
                        multiple
                    >
                    <label for="identity-proofs">
                        <img src="{{ asset('/images/icons/upload.png') }}" alt="Upload"/>
                        <span>Upload your ID Proofs here</span>
                    </label>
                </div>

                @if ($method)
                    <div class="mt-3 text-right">
                        <button class="nav-btn bg-purple color-purple"
                            type="button"
                            data-toggle="collapse"
                            data-target="#files-collapse"
                        >
                            Files
                        </button>
                    </div>

                    <div class="collapse" id="files-collapse">
                        <ul class="list-group">
                            @foreach ($member->getMedia('identity_proofs') as $media)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ $media->getFullUrl() }}" class="h6" target="_blank">
                                        {{ $media->file_name }}
                                    </a>

                                    <button type="button" class="btn btn-link remove-media" data-id="{{ $media->id }}">
                                        <img src="/images/icons/up-close.png" alt="Close"/>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="form-input col-12 col-lg-6 pt-4">
                <label>
                    {{ __('First Name') }}
                    <input name="first_name"
                        type="text"
                        value="{{ old('first_name', $member->first_name) }}"
                        placeholder="{{ __('First Name') }}"
                        required
                    >
                </label>
            </div>

            <div class="form-input col-12 col-lg-6 pt-4">
                <label>
                    {{ __('Last Name') }}
                    <input name="last_name"
                        type="text"
                        value="{{ old('last_name', $member->last_name) }}"
                        placeholder="{{ __('Last Name') }}"
                        required
                    >
                </label>
            </div>

            <div class="form-input col-12 col-lg-6 pt-4">
                <label>
                    {{ __('Email') }}
                    <input name="email"
                        type="email"
                        value="{{ old('email', $member->email) }}"
                        placeholder="{{ __('Email') }}"
                        required
                    >
                </label>
            </div>

            <div class="form-input col-12 col-lg-6 pt-4">
                <label>
                    {{ __('Phone No.') }}
                    <input name="phone"
                        type="text"
                        value="{{ old('phone', $member->phone) }}"
                        placeholder="{{ __('Phone No.') }}"
                        required
                    >
                </label>
            </div>

            <div class="form-input col-12 col-lg-6">
                <label>
                    {{ __('Member Valid Till') }}
                    <div class="input-group">
                        <input type="text"
                            name="validity_date"
                            class="validity-date"
                            placeholder="{{ __('Validity Date') }}"
                            value="{{ old('validity_date', $member->validity_date) }}"
                            required
                        >
                        <span class="input-group-addon">
                            <img src="{{ asset('/images/icons/calendar.png') }}" alt="Calendar">
                        </span>
                    </div>
                </label>
            </div>

            <div class="form-input col-12 col-lg-6">
                <label>
                    {{ __('Gender') }}
                    <span class="d-flex align-items-center pt-1">
                        <span class="radio">
                            <input name="gender"
                                id="male-radio"
                                type="radio"
                                value="1"
                                checked
                                required
                            >
                            <label for="male-radio" class="radio-label d-flex align-items-center">
                                {{ __('Male') }}
                            </label>
                        </span>

                        <span class="radio ml-5">
                            <input name="gender"
                                id="female-radio"
                                type="radio"
                                value="2"
                                {{ old("gender", $member->gender) == "2" ? "checked" : "" }}
                            >
                            <label for="female-radio" class="radio-label  d-flex align-items-center">
                                {{ __('Female') }}
                            </label>
                        </span>
                    </span>
                </label>
            </div>

            <div class="form-input col-12 col-lg-6">
                <label>
                    {{ __('Emergency No.') }}
                    <input name="emergency_number"
                        type="text"
                        value="{{ old('emergency_number', $member->emergency_number) }}"
                        placeholder="{{ __('Emergency No.') }}"
                    >
                </label>
            </div>

            <div class="col-12 col-lg-6">
                <div class="form-group select-member mail-select-member">
                    <label>{{ __('Members Timings') }}</label>

                    <select
                        name="timings[]"
                        class="chosen-select"
                        data-placeholder="@lang('Select Timings')"
                        multiple
                    >
                        @php
                            $currentTimings = $member->timings ? $member->timings->pluck('id')->toArray() : [];
                            $selectedTimings = old('timings', $currentTimings);
                        @endphp

                        @foreach ($timings as $timing)
                            <option value="{{ $timing->id }}"
                                {{ in_array($timing->id, $selectedTimings) ? 'selected' : '' }}
                            >
                                {{ $timing->start_time." - ".$timing->end_time }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-input col-12 col-lg-6">
                <label>
                    {{ __('Status') }}
                    <span class="d-flex align-items-center pt-1">
                        <span class="radio">
                            <input name="status"
                                id="status-active"
                                type="radio"
                                value="1"
                                checked
                                required
                            >
                            <label for="status-active" class="radio-label d-flex align-items-center">
                                {{ __('Active') }}
                            </label>
                        </span>

                        <span class="radio ml-5">
                            <input name="status"
                                id="status-deactivate"
                                type="radio"
                                value="0"
                                {{ old("status", $member->status) == "0" ? "checked" : "" }}
                            >
                            <label for="status-deactivate" class="radio-label  d-flex align-items-center">
                                {{ __('Inactive') }}
                            </label>
                        </span>
                    </span>
                </label>
            </div>

            @if ($method)
                <div class="form-input col-12 col-lg-6 pt-4">
                    <label>
                        {{ __('BMI') }}
                        <input type="text" value="{{$bmi ? $bmi : __('select height and weight to show bmi')}}" readonly>
                    </label>
                </div>
            @endif
        </div>

        <div class="head w-100">@lang('Other Details')</div>

        <div class="row pt-4">
            <div class="form-input col-12 col-lg-6">
                <label>
                    {{ __('Referenced by') }}
                    <select
                        name="referred_by"
                        class="selectpicker btn-primary"
                        id="referred-by"
                    >
                        <option value="">@lang('Select Referrer')</option>
                        @foreach ($members as $memberDetail)
                            <option value="{{ $memberDetail->id }}"
                                {{ old('referred_by', $member->referred_by) == $memberDetail->id ? "selected" : "" }}
                            >
                                {{ $memberDetail->getName() }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="form-input col-12 col-lg-6">
                <label>
                    {{ __('Membership Plan') }}
                    <select
                        name="membership_plan_id"
                        class="selectpicker btn-primary"
                        id="membership-plan"
                    >
                        <option value="">@lang('Select Membership Plan')</option>

                        @foreach ($membershipPlans as $membershipPlan)
                            <option value="{{ $membershipPlan->id }}"
                                {{ old('membership_plan_id', $member->membership_plan_id) == $membershipPlan->id ? "selected" : "" }}
                            >
                                {{ $membershipPlan->name }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="form-input col-12 col-lg-6">
                <label>
                    {{ __('Height(cms)') }}
                    <input name="height"
                        type="number"
                        value="{{ old('height', $member->height) }}"
                        placeholder="{{ __('Height') }}"
                    >
                </label>
            </div>

            <div class="form-input col-12 col-lg-6">
                <label>
                    {{ __('Date of Birth') }}
                    <div class="input-group">
                        <input type="text"
                            name="date_of_birth"
                            class="date-of-birth"
                            placeholder="{{ __('Date of Birth') }}"
                            value="{{ old('date_of_birth', $member->date_of_birth) }}"
                            required
                        >
                        <span class="input-group-addon">
                            <img src="{{ asset('/images/icons/calendar.png') }}" alt="Calendar">
                        </span>
                    </div>
                </label>
            </div>

            <div class="form-input col-12 col-lg-6">
                <label>
                    {{ __('Member Since') }}
                    <div class="input-group">
                        <input type="text"
                            name="member_since"
                            class="member-since"
                            placeholder="{{ __('Member Since') }}"
                            value="{{ old('member_since', $member->member_since) }}"
                            required
                        >
                        <span class="input-group-addon">
                            <img src="{{ asset('/images/icons/calendar.png') }}" alt="Calendar">
                        </span>
                    </div>
                </label>
            </div>

            <div class="form-input col-12 col-lg-6">
                <label>
                    {{ __('Address') }}
                    <div class="input-group">
                        <input name="address"
                            type="text"
                            value="{{ old('address', $member->address) }}"
                            placeholder="{{ __('Address') }}"
                            autocomplete="off"
                            required
                        >
                    </div>
                </label>
            </div>

            <div class="form-input col-12">
                <label class="textarea-label">
                    {{ __('Notes') }}
                    <textarea name="notes" placeholder="Click Here To Write Note">{{ old('notes', $member->notes) }}</textarea>
                </label>
            </div>

            <div class="form-input col-12 col-lg-6">
                <a href="{{ route('admin.members.index') }}">
                    <button type="button" class="nav-btn bg-red color-red mr-3">{{ __('Cancel') }}</button>
                </a>

                <button type="submit" class="nav-btn bg-blue color-blue">
                    {{ $method ? __('Update') : __('Submit') }}
                </button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
    <script src="https://unpkg.com/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>

    <script>
        $(function() {
            flatpickr('.date-of-birth');
            flatpickr('.validity-date');
            flatpickr('.member-since');
            $(".chosen-select").chosen();

            $("#member-image-upload").change(function() {
                updateImagePreview(this);
            });

            $(".remove-media").click(function() {
                var element = $(this);

                $.ajax({
                    method: "POST",
                    url: "/admin/members/{{ $member->id }}/remove-identification-proof/"+$(this).attr('data-id'),
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        new PNotify({
                            text: 'Identification proof removed successfully.',
                            styling: "bootstrap3",
                            type: 'success',
                        });

                        $(element).parent().remove();
                    }, error: function (xhr) {
                        new PNotify({
                            text: 'Something went wrong!',
                            styling: "bootstrap3",
                            type: 'error',
                        });
                    },
                });
            });
        });

        function updateImagePreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-preview').css('background-image', 'url('+e.target.result +')');
                    $('#image-preview').hide();
                    $('#image-preview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
