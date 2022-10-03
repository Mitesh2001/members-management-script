@push('styles')
    <link rel="stylesheet"
        href="https://www.jqueryscript.net/demo/Bootstrap-4-Dropdown-Select-Plugin-jQuery/dist/css/bootstrap-select.css">
    <link property='stylesheet'
        href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
@endpush

<form method="post" action="{{ $route }}">
    @csrf

    @if ($method)
        @method($method)
    @endif

    <div class="member-card">
        <div class="d-flex align-items-center justify-content-between mb-20 border-bottom pb-3 flex-wrap">
            <div class="title-main">
                <h2 class="title">
                    {{ $method ? __('Update Timing') : __('Add New Timing') }}
                </h2>
            </div>

            <div class="button-main">
                <a href="{{ route('admin.timings.index') }}">
                    <button type="button" class="nav-btn bg-red color-red mr-3">
                        {{ __('Cancel') }}
                    </button>
                </a>

                <button type="submit" class="nav-btn bg-blue color-blue">
                    {{ $method ? __('Update') : __('Submit') }}
                </button>
            </div>
        </div>

        <div class="row">
            <div class="form-input col-12 col-lg-6">
                <label>
                    {{ __('Start Time') }}
                    <select class="selectpicker btn-primary" name="start_time" required>
                        <option selected disabled>{{ __('Select Start Time') }}</option>

                        @foreach ($timingOptions as $key => $value)
                            <option value="{{ $key }}"
                                {{ old('start_time', $timing->start_time) == $key ? "selected" : "" }}
                            >
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="form-input col-12 col-lg-6">
                <label>
                    {{ __('End Time') }}
                    <select class="selectpicker btn-primary" name="end_time" required>
                        <option selected disabled>{{ __('Select End Time') }}</option>

                        @foreach ($timingOptions as $key => $value)
                            <option value="{{ $key }}"
                                {{ old('end_time', $timing->end_time) == $key ? "selected" : "" }}
                            >
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="col-12 col-lg-6">
                <div class="form-group select-member mail-select-member">
                    <label>{{ __('Trainers') }}</label>
                    <select
                        name="trainers[]"
                        data-placeholder="{{__('Select Trainers')}}"
                        multiple
                        class="chosen-select"
                    >
                        @php
                            $currentTrainers = $timing->trainers ? $timing->trainers->pluck('id')->toArray() : [];
                            $selectedTrainers = old('trainers', $currentTrainers);
                        @endphp

                        @foreach ($trainers as $trainer)
                            <option value="{{ $trainer->id }}"
                                {{ in_array($trainer->id, $selectedTrainers) ? 'selected' : '' }}
                            >
                                {{ $trainer->getName() }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="form-group select-member mail-select-member">
                    <label>{{ __('Members') }}</label>

                    <select
                        name="members[]"
                        data-placeholder="{{__('Select Members')}}"
                        multiple
                        class="chosen-select"
                    >
                        @php
                            $currentMembers = $timing->members ? $timing->members->pluck('id')->toArray() : [];
                            $selectedMembers = old('members', $currentMembers);
                        @endphp

                        @foreach ($members as $member)
                            <option value="{{ $member->id }}"
                                {{ in_array($member->id, $selectedMembers) ? 'selected' : '' }}
                            >
                                {{ $member->getName() }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-input col-12">
                <label class="textarea-label">
                    {{ __('Notes') }}
                    <textarea name="notes" placeholder="Click Here To Write Note">{{ old('notes', $timing->notes) }}</textarea>
                </label>
            </div>
        </div>
    </div>
</form>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>

    <script>
        $(function(){
            $(".chosen-select").chosen();
        });
    </script>
@endpush
